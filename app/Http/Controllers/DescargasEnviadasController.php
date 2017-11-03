<?php

namespace lotecweb\Http\Controllers;

use DateInterval;
use DateTime;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use lotecweb\Http\Requests;
use lotecweb\Models\Usuario;
use lotecweb\Models\Usuario_ven;
use lotecweb\Models\Vendedor;

class DescargasEnviadasController extends StandardController
{
    protected $model;
    protected $nameView = 'dashboard.descargasenviadas';
    protected $data;
    protected $title = 'Descargas Enviadas';
    protected $redirectCad = '/admin/contatos/cadastrar';
    protected $redirectEdit = '/admin/contatos/editar';
    protected $route = '/admin/contatos';
    public $data_inicial;
    public $data_fim;

    public function __construct(
        Usuario $usuario,
        Usuario_ven $usuario_ven,
        Vendedor $vendedor,
        Request $request)
    {
        $this->request = $request;
        $this->usuario = $usuario;
        $this->usuario_ven = $usuario_ven;
        $this->vendedor = $vendedor;


    }

    public function index2($ideven)
    {



        if (Auth::user()->idusu == 1000){

            $data = $this->vendedor
                ->select('ideven')
                ->get();

            $palavra = "";


            $c = 0;
            foreach ($data as $key){

//                echo  $key['ideven'].'\n';
//                echo $c.'\n';
                $palavra = $palavra.$key['ideven'];
                if ($c < count($data)-1){
                    $palavra = $palavra.",";
                }
                $c++;


            }
            $ideven = $palavra;



        } else{
            $ideven = $ideven;
        }


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

//dd($idusu);

//        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $vendedores = $this->retornaBasesUser($idusu);


        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

//        $data = $this->retornaResumoCaixa($ideven);

        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);

        $descarga = $this->returnVendDesg($ideven);

        $semana = $this->returnLoteriaDia();

        $loterias = $this->returnLoterias();

        $data = $this->returnDescargasEnviadas();



        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll', 'ideven',
            'descarga', 'semana', 'loterias'));
    }

    public function indexGo()
    {


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaBasesUser($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $data = $this->retornaResumoCaixaParameter();


        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);


        //referente aos IDEVEN
        $valor = $this->request->get('sel_vendedor');
//         dd($valor);

        if (isset($valor)){
//            $ideven2 = implode(",", $valor);
            $ideven2 = $valor;
        } else{

            $valor = $this->retornaBasesPadrao($idusu);
//            dd($valor);
            $ideven2  = $valor;
//            dd('ok!!');

        }

//dd($ideven2);

        $dados = $this->request->get('sel_options');
        $in_ativos = '';



        if (isset($dados)){
            if (in_array(1, $dados)) {
                $despesas = 'SIM';
            }else {
                $despesas = 'NAO';}

            if (in_array(2, $dados)) {
                $in_ativos = 'SIM';
            } else
                $in_ativos = 'NAO';
        }



                return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll','ideven2', 'despesas','in_ativos'));
    }

    public function retornaResumoCaixa($ideven){




        $datIni = date ("Y/m/d");
        $datFim = date ("Y/m/d");

        $this->data_inicial = $datIni;
        $this->data_fim = $datFim;

        //data atual menos um dia
        $inicio = $datIni; // data inicio menos um dia
        $parcelas = 1;
        $data_termino = new DateTime($inicio);
        $data_termino->sub(new DateInterval('P'.$parcelas.'D'));
        $datAnt = $data_termino->format('Y/m/d');



        $data = DB::select (

            "SELECT REVENDEDOR.NOMREVEN, REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN, '$datIni' AS DATAINI, '$datFim' AS DATAFIM,
        (SELECT SUM(RESUMO_CAIXA.VLRVEN)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRVEN,
        (SELECT SUM(RESUMO_CAIXA.VLRCOM)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRCOM,
        (SELECT SUM(RESUMO_CAIXA.VLRLIQBRU)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRLIQBRU,
        (SELECT SUM(RESUMO_CAIXA.VLRPREMIO)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRPREMIO,
        (SELECT SUM(RESUMO_CAIXA.VLRRECEB)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRRECEB,

        (SELECT SUM(RESUMO_CAIXA.VLRPAGOU)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRPAGOU,

        (SELECT SUM(RESUMO_CAIXA.VLRTRANSR)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRTRANSR,

        (SELECT SUM(RESUMO_CAIXA.VLRTRANSP)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRTRANSP,

        (SELECT RESUMO_CAIXA.VLRDEVATU
            FROM RESUMO_CAIXA
             WHERE
               RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
               RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
               RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
               RESUMO_CAIXA.DATMOV  = (SELECT MAX(RC.DATMOV)
                                        FROM RESUMO_CAIXA RC
                                         WHERE
                                          RC.IDBASE = RESUMO_CAIXA.IDBASE AND
                                          RC.IDVEN = RESUMO_CAIXA.IDVEN AND
                                          RC.IDREVEN = RESUMO_CAIXA.IDREVEN AND
                                          RC.DATMOV <= '$datAnt' )) AS VLRDEVANT,

        (SELECT RESUMO_CAIXA.VLRDEVATU
           FROM RESUMO_CAIXA
            WHERE
             RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
             RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
             RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
             RESUMO_CAIXA.DATMOV  = (SELECT MAX(RC.DATMOV)
                                        FROM RESUMO_CAIXA RC
                                         WHERE
                                          RC.IDBASE = RESUMO_CAIXA.IDBASE AND
                                          RC.IDVEN = RESUMO_CAIXA.IDVEN AND
                                          RC.IDREVEN = RESUMO_CAIXA.IDREVEN AND
                                          RC.DATMOV <= '$datFim' )) AS VLRDEVATU,

        (SELECT SUM(RESUMO_CAIXA.DESPESA)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS DESPESAS,

        (SELECT MAX(RESUMO_CAIXA.DATMOV)
           FROM RESUMO_CAIXA
            WHERE
              RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
              RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
              RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
              RESUMO_CAIXA.VLRVEN > 0 AND
              RESUMO_CAIXA.DATMOV <= '$datFim' ) AS DATAULTVEN
   FROM
     REVENDEDOR
   INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = REVENDEDOR.IDBASE AND
        VENDEDOR.IDVEN = REVENDEDOR.IDVEN
    WHERE
     REVENDEDOR.IDREVEN <> 99999999
     
     AND VENDEDOR.IDEVEN in ($ideven)
     
     AND REVENDEDOR.SITREVEN = 'ATIVO'
     
     
     ORDER BY REVENDEDOR.NOMREVEN DESC
     
     "

        );


        return $data;
    }

    /**
     * @return mixed
     */
    public function retornaResumoCaixaParameter(){

        $dados = $this->request->get('sel_options');
        $in_ativos = '';

        if (isset($dados)){
            if (in_array(1, $dados)) {
                $despesas = 'SIM';
            }

            if (in_array(2, $dados)) {
                $in_ativos = 'SIM';
            } else
                $in_ativos = 'NAO';
        }


        if ($in_ativos == 'SIM'){
            $p_in_ativo = '';
        } else {
            $p_in_ativo = "AND REVENDEDOR.SITREVEN = 'ATIVO'";
        }





        $datIni = $this->request->get('datIni');
        $datFim = $this->request->get('datFim');

        if (empty($datFim) || empty($datIni)) {
            $datIni = date ("Y/m/d");
            $datFim = date ("Y/m/d");
        } else {
            //Converte data inicial de string para Date(y/m/d)
            $datetimeinicial = new DateTime();
            $newDateInicial = $datetimeinicial->createFromFormat('d/m/Y', $datIni);

            $datIni = $newDateInicial->format('Y/m/d');

            //Converte data final de string para Date(y/m/d)
            $datetimefinal = new DateTime();
            $newDateFinal = $datetimefinal->createFromFormat('d/m/Y', $datFim);

            $datFim = $newDateFinal->format('Y/m/d');

        }
            $inicio = $datIni; // data inicio menos um dia
            $parcelas = 1;
            $data_termino = new DateTime($inicio);
            $data_termino->sub(new DateInterval('P' . $parcelas . 'D'));
            $datAnt = $data_termino->format('Y/m/d');




        $codigo = Auth::user()->idusu;

        //referente aos IDEVEN
        $valor = $this->request->get('sel_vendedor');
        if ($valor == NULL){
            $valor = $this->retornaBasesPadrao($codigo);
//            dd($valor);
            $p = $valor;
        } else {

            //Construi a string com base no array do select via form
            $p = implode(",", $valor);
        }

//        dd($valor);


        $data = DB::select (

            "SELECT REVENDEDOR.NOMREVEN, REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN, '$datIni' AS DATAINI, '$datFim' AS DATAFIM,
        (SELECT SUM(RESUMO_CAIXA.VLRVEN)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRVEN,
        (SELECT SUM(RESUMO_CAIXA.VLRCOM)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRCOM,
        (SELECT SUM(RESUMO_CAIXA.VLRLIQBRU)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRLIQBRU,
        (SELECT SUM(RESUMO_CAIXA.VLRPREMIO)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRPREMIO,
        (SELECT SUM(RESUMO_CAIXA.VLRRECEB)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRRECEB,

        (SELECT SUM(RESUMO_CAIXA.VLRPAGOU)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRPAGOU,

        (SELECT SUM(RESUMO_CAIXA.VLRTRANSR)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRTRANSR,

        (SELECT SUM(RESUMO_CAIXA.VLRTRANSP)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS VLRTRANSP,

        (SELECT RESUMO_CAIXA.VLRDEVATU
            FROM RESUMO_CAIXA
             WHERE
               RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
               RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
               RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
               RESUMO_CAIXA.DATMOV  = (SELECT MAX(RC.DATMOV)
                                        FROM RESUMO_CAIXA RC
                                         WHERE
                                          RC.IDBASE = RESUMO_CAIXA.IDBASE AND
                                          RC.IDVEN = RESUMO_CAIXA.IDVEN AND
                                          RC.IDREVEN = RESUMO_CAIXA.IDREVEN AND
                                          RC.DATMOV <= '$datAnt' )) AS VLRDEVANT,

        (SELECT RESUMO_CAIXA.VLRDEVATU
           FROM RESUMO_CAIXA
            WHERE
             RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
             RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
             RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
             RESUMO_CAIXA.DATMOV  = (SELECT MAX(RC.DATMOV)
                                        FROM RESUMO_CAIXA RC
                                         WHERE
                                          RC.IDBASE = RESUMO_CAIXA.IDBASE AND
                                          RC.IDVEN = RESUMO_CAIXA.IDVEN AND
                                          RC.IDREVEN = RESUMO_CAIXA.IDREVEN AND
                                          RC.DATMOV <= '$datFim' )) AS VLRDEVATU,

        (SELECT SUM(RESUMO_CAIXA.DESPESA)
          FROM RESUMO_CAIXA
           WHERE
            RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
            RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
            RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
            RESUMO_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim') AS DESPESAS,

        (SELECT MAX(RESUMO_CAIXA.DATMOV)
           FROM RESUMO_CAIXA
            WHERE
              RESUMO_CAIXA.IDBASE  = REVENDEDOR.IDBASE AND
              RESUMO_CAIXA.IDVEN   = REVENDEDOR.IDVEN AND
              RESUMO_CAIXA.IDREVEN = REVENDEDOR.IDREVEN AND
              RESUMO_CAIXA.VLRVEN > 0 AND
              RESUMO_CAIXA.DATMOV <= '$datFim' ) AS DATAULTVEN
   FROM
     REVENDEDOR
   INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = REVENDEDOR.IDBASE AND
        VENDEDOR.IDVEN = REVENDEDOR.IDVEN
    WHERE
     REVENDEDOR.IDREVEN <> 99999999
     
     AND VENDEDOR.IDEVEN in ($p)
     
     
    $p_in_ativo
     
     
     ORDER BY REVENDEDOR.NOMREVEN DESC
     
     "

        );




//        dd($data);

        return $data;
    }


    public function retornaBasesPadrao($id){


        $data = $this->usuario_ven

            ->select('ideven')

            ->where([
                ['idusu', '=', $id],
                ['inpadrao', '=', 'SIM']
            ])
            ->first();


        return $data->ideven;
    }



    public function retornaBasesAll($id){

        if ($id == 1000){
            $data = DB::table('VENDEDOR')
                ->orderBy('NOMVEN', 'asc')
                ->get();
            return $data;

        } else{

            $data = $this->usuario_ven


//            ->select('USUARIO_VEN.*')
                ->join('VENDEDOR', [
                    ['USUARIO_VEN.IDVEN','=','VENDEDOR.IDVEN'],
                    ['USUARIO_VEN.IDBASE', '=', 'VENDEDOR.IDBASE']])
                ->join('BASE', 'USUARIO_VEN.IDBASE', '=', 'BASE.IDBASE')
                ->where([
                    ['USUARIO_VEN.idusu', '=', $id]
                ])
                ->orderby('INPADRAO', 'DESC')
                ->get();

            return $data;
        }

    }


    public function retornaBasesUser($id){


        $data = $this->usuario_ven

//            ->select('USUARIO_VEN.*')
            ->join('VENDEDOR', [
                ['USUARIO_VEN.IDVEN','=','VENDEDOR.IDVEN'],
                ['USUARIO_VEN.IDBASE', '=', 'VENDEDOR.IDBASE']])
            ->join('BASE', 'USUARIO_VEN.IDBASE', '=', 'BASE.IDBASE')
            ->where([
                ['USUARIO_VEN.idusu', '=', $id]
            ])
            ->orderby('INPADRAO', 'DESC')
            ->get();


//        dd($data);

        return $data;
    }

    public function retornaApostaPremios($idven, $idbase, $idreven, $datini, $datfim){

//        $datini = date ("Y/m/d");
//        $datfim = date ("Y/m/d");

        $data = DB::select (" 
            SELECT APOSTA_PALPITES.IDBASE, APOSTA_PALPITES.IDVEN, APOSTA_PALPITES.IDREVEN, 
           APOSTA_PALPITES.IDTER, APOSTA_PALPITES.IDAPO, APOSTA_PALPITES.NUMPULE,
           APOSTA_PALPITES.SEQPALP, APOSTA_PALPITES.DATAPO,APOSTA_PALPITES.IDMENU,
           APOSTA_PALPITES.IDTIPOAPO,APOSTA_PALPITES.IDLOT,APOSTA_PALPITES.IDHOR,
           APOSTA_PALPITES.IDCOL,APOSTA_PALPITES.VLRPALP,APOSTA_PALPITES.PALP1,
           APOSTA_PALPITES.PALP2,APOSTA_PALPITES.PALP3,APOSTA_PALPITES.PALP4,
           APOSTA_PALPITES.PALP5,APOSTA_PALPITES.PALP6,APOSTA_PALPITES.PALP7,
           APOSTA_PALPITES.PALP8,APOSTA_PALPITES.PALP9,APOSTA_PALPITES.PALP10,
           APOSTA_PALPITES.PALP11,APOSTA_PALPITES.PALP12,APOSTA_PALPITES.PALP13,
           APOSTA_PALPITES.PALP14,APOSTA_PALPITES.PALP15,APOSTA_PALPITES.SITAPO,
           APOSTA_PALPITES.VLRCOM,APOSTA_PALPITES.VLRPRESEC,APOSTA_PALPITES.VLRPREMOL,
           APOSTA_PALPITES.VLRPRE,APOSTA_PALPITES.COLMOTDES,APOSTA_PALPITES.VLRPRESMJ,
           APOSTA_PALPITES.VLRPALPF,APOSTA_PALPITES.VLRPALPD,APOSTA_PALPITES.VLRPREPAG,
           APOSTA_PALPITES.DATENV, APOSTA_PALPITES.HORENV,APOSTA_PALPITES.INCOMB,
           APOSTA_PALPITES.VLRCOTACAO,APOSTA_PALPITES.DATCAN,APOSTA_PALPITES.HORCAN,
           APOSTA_PALPITES.SITPRE,APOSTA_PALPITES.DATLIBPRE,APOSTA_PALPITES.HORLIBPRE,
           APOSTA_PALPITES.DATLIMPRE, APOSTA_PALPITES.INATRASADO, APOSTA_PALPITES.INSORPRO, 
           APOSTA_PALPITES.INFODESC, APOSTA_PALPITES.PALP16,APOSTA_PALPITES.PALP17,
           APOSTA_PALPITES.PALP18,APOSTA_PALPITES.PALP19,APOSTA_PALPITES.PALP20,
           APOSTA_PALPITES.PALP21,APOSTA_PALPITES.PALP22,APOSTA_PALPITES.PALP23,
           APOSTA_PALPITES.PALP24,APOSTA_PALPITES.PALP25,APOSTA_PALPITES.PRELIBMANUAL,
           APOSTA_PALPITES.NUMAUT,APOSTA_PALPITES.VLR_AUX,
           REVENDEDOR.NOMREVEN,
           HOR_APOSTA.DESHOR,
           TIPO_APOSTA.DESTIPOAPO,
           COLOCACOES.DESCOL, ' ' as inSel
      FROM APOSTA_PALPITES
      INNER JOIN REVENDEDOR ON REVENDEDOR.IDBASE = APOSTA_PALPITES.IDBASE AND
                               REVENDEDOR.IDVEN = APOSTA_PALPITES.IDVEN AND
                               REVENDEDOR.IDREVEN = APOSTA_PALPITES.IDREVEN
      INNER JOIN HOR_APOSTA ON HOR_APOSTA.IDLOT = APOSTA_PALPITES.IDLOT AND
                               HOR_APOSTA.IDHOR = APOSTA_PALPITES.IDHOR
      INNER JOIN TIPO_APOSTA ON TIPO_APOSTA.IDTIPOAPO = APOSTA_PALPITES.IDTIPOAPO
      INNER JOIN COLOCACOES ON COLOCACOES.IDCOL = APOSTA_PALPITES.IDCOL
      WHERE
          APOSTA_PALPITES.SITAPO = 'PRE'
      AND APOSTA_PALPITES.DATLIBPRE BETWEEN '$datini' AND '$datfim'
      AND APOSTA_PALPITES.IDBASE = $idbase
      AND APOSTA_PALPITES.IDVEN = $idven
      AND APOSTA_PALPITES.IDREVEN = $idreven
        ");


//        dd($data);

        return view('dashboard.apostapremiada', compact('data'));
    }

    public function returnVendDesg($ideven){

        $p = $this->retornaBasepeloIdeven($ideven);

        $data = DB::select("SELECT VEN_DESC.IDBASEDESC, VEN_DESC.IDVENDESC, VENDEDOR.NOMVEN   
                            FROM VEN_DESC
                            INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = VEN_DESC.IDBASEDESC AND
                            VENDEDOR.IDVEN = VEN_DESC.IDVENDESC
                            WHERE
                              VEN_DESC.SITLIG = 'ATIVO' AND
                              VEN_DESC.IDBASE = '$p->idbase' AND
                              VEN_DESC.IDVEN = '$p->idven' ");

        return $data;
    }

    public function returnLoteriaDia(){
        $w = date("w");


        switch ($w) {
            case 0:
                $dd = "DOMINGO";
                break;
            case 1:
                $dd = "SEGUNDA";
                break;
            case 2:
                $dd = "TERÇA";
                break;
            case 3:
                $dd = "QUARTA";
                break;
            case 4:
                $dd = "QUINTA";
                break;
            case 5:
                $dd = "SEXTA";
                break;
            case 6:
                $dd = "SABADO";
                break;
        }

        $data = DB::select(" SELECT HOR_APOSTA.IDLOT, HOR_APOSTA.IDHOR, HOR_APOSTA.DESHOR, HOR_APOSTA.IDEHOR, 'N' AS CHEK
                              FROM HOR_APOSTA
                              WHERE
                             HOR_APOSTA.DIASEM = '$dd' AND
                             HOR_APOSTA.SITHOR = 'ATIVO'
                             ORDER BY HOR_APOSTA.HORLIM, HOR_APOSTA.DESHOR DESC 
     ");

        return $data;
    }

    public function returnLoterias(){
        $data = DB::select(" SELECT IDLOT, DESLOT FROM LOTERIAS ORDER BY IDLOT ASC");

        return $data;
    }

    public function returnDescargasEnviadas(){
        $var_cond = 3;
        $hora = '2017-11-03';
        $dat = '2017-11-03';
        $dataini = '2017-11-03';
        $datafim = '2017-11-03';
        $var_query_1 = '';
        $var_query_2 = '';
        $var_query_3 = '';
        $var_query_4 = '';
        $var_query_5 = '';
        $var_query_6 = '';
        $var_string_ven = '';
        //Origem
        $idbaseo = '';
        $idveno = '';
        //Destino
        $idbased = '';
        $idvend = '';
        //pesquisa palpite
        $palpite = '';
        //pesquisar por horário loterias
        $var_hora_select = '';
        //pesquisar loteria
        $var_loteria_select = '';

        $idusu = auth()->user()->idusu;
        $admin = Usuario::where('idusu', '=', $idusu)->first();


        if($var_cond != 3){

            if ($var_cond = 0 ){
                //Se situação = 0
                $var_query_1 = " AND APOSTA_DESCARGA.SITDES = 'EL' AND
                        ((((SELECT CONCAT(CONCAT(RPAD(EXTRACT(HOUR FROM HA.HORLIM),2,0),':'),
                            CONCAT(CONCAT(RPAD(EXTRACT(MINUTE FROM HA.HORLIM),2,0),':'),RPAD(EXTRACT(Second FROM HA.HORLIM),2,0)))
                        FROM HOR_APOSTA HA
                        WHERE
                        HA.IDLOT = APOSTA_PALPITES.IDLOT AND
                        HA.IDHOR = APOSTA_PALPITES.IDHOR) > '$hora')
                        AND (APOSTA_PALPITES.DATAPO = '$dat')) OR
                        (APOSTA_PALPITES.DATAPO > '$dat'))
                        AND APOSTA_PALPITES.DATENV between '$dataini' AND '$datafim'";
            } elseif ($var_cond = 1 ){
                //Se situação = 1
                $var_query_1 = "AND APOSTA_DESCARGA.SITDES = 'PRO' 
                        AND APOSTA_PALPITES.DATENV between '$dataini' AND '$datafim'";
            } elseif ($var_cond = 2 ){
                //Se situação = 2
                $var_query_1 = " AND APOSTA_DESCARGA.SITDES = ''EL'' AND
                            ((((SELECT CONCAT(CONCAT(RPAD(EXTRACT(HOUR FROM HA.HORLIM),2,0),'':''),
                             CONCAT(CONCAT(RPAD(EXTRACT(MINUTE FROM HA.HORLIM),2,0),'':''),RPAD(EXTRACT(Second FROM HA.HORLIM),2,0)))
                              FROM HOR_APOSTA HA
                               WHERE
                               HA.IDLOT = APOSTA_PALPITES.IDLOT AND
                               HA.IDHOR = APOSTA_PALPITES.IDHOR) < '$hora')
                               AND (APOSTA_PALPITES.DATAPO = '$dat')) OR
                               (APOSTA_PALPITES.DATAPO < ''$dat))
                               AND APOSTA_PALPITES.DATENV between '$dataini' AND '$datafim'";
            } else {
                //Se não
                $var_query_1 = "AND APOSTA_PALPITES.DATENV between '$dataini' AND '$datafim'";
            }
        }


        //Vendedor Origem selecionado por base
       if (empty($var_string_ven)) {
           if ($admin->inadim = 'NAO') {

               $var_query_2 = " AND APOSTA_DESCARGA.IDBASEO = '$idbaseo' 
                                    AND APOSTA_DESCARGA.IDVENO  = '$idveno'";

           }
       } else {
           $var_query_2 = " AND VEN_O.IDEVEN IN '$var_string_ven' ";
       }

       //Vendedor Destino selecionado
        if (!empty($idbased)){
            $var_query_3 = " AND APOSTA_DESCARGA.IDBASED = '$idbased'
                        AND APOSTA_DESCARGA.IDVEND  = '$idvend'";
        }

        //Pesquisar Palpite
        if (!empty($palpite)){
            $var_query_4 = " AND APOSTA_PALPITES.PALP1 LIKE '"%".$palpite."%"'";
        }

        //pesquisar por horário loterias
        if (!empty($var_hora_select)){
            $var_query_5 = " AND HOR_APOSTA.IDEHOR IN '$var_hora_select";
        }
        //pesquisar por loteria selecionada
        if (!empty($var_loteria_select)){
            $var_query_6 = " AND LOTERIAS.IDLOT = '$var_loteria_select";
        }



        $data = DB::select(" 
                    SELECT APOSTA_DESCARGA.IDBASE,APOSTA_DESCARGA.IDVEN,APOSTA_DESCARGA.IDREVEN,
                    APOSTA_DESCARGA.IDTER,APOSTA_DESCARGA.IDAPO,APOSTA_DESCARGA.NUMPULE, 
                    APOSTA_DESCARGA.SEQPALP, APOSTA_DESCARGA.SEQDES,APOSTA_DESCARGA.IDBASED, 
                    APOSTA_DESCARGA.IDVEND,APOSTA_DESCARGA.IDBASEO,APOSTA_DESCARGA.IDVENO, 
                    APOSTA_DESCARGA.VLRPALPO,APOSTA_DESCARGA.VLRPALP,APOSTA_DESCARGA.VLRPALPF, 
                    APOSTA_DESCARGA.VLRPALPD,APOSTA_DESCARGA.VLRPRESEC,APOSTA_DESCARGA.VLRPREMOL, 
                    APOSTA_DESCARGA.VLRPRESMJ,APOSTA_DESCARGA.VLRPRE,APOSTA_DESCARGA.VLRPREPAG, 
                    APOSTA_DESCARGA.SITDES,APOSTA_DESCARGA.COLMOTDES,APOSTA_DESCARGA.COLPRE, 
                    APOSTA_DESCARGA.PERDESC,APOSTA_DESCARGA.DATAPO,APOSTA_DESCARGA.HORAPO, 
                    APOSTA_DESCARGA.IDTIPOAPO,APOSTA_DESCARGA.IDCOL,APOSTA_DESCARGA.DATENV, 
                    APOSTA_DESCARGA.HORENV,APOSTA_DESCARGA.GRUPDES,APOSTA_DESCARGA.INCOMB, 
                    APOSTA_DESCARGA.VLRCOTACAO,APOSTA_DESCARGA.IDMENU,APOSTA_DESCARGA.INFODESC, 
                    APOSTA_DESCARGA.TIPODESC,APOSTA_DESCARGA.VLRPALPSECO,APOSTA_DESCARGA.VLRPALPMOLHADO, 
                    APOSTA_DESCARGA.INVISU,APOSTA_DESCARGA.IDCOLDESC, 
                    VENDEDOR.NOMVEN, 
                    HOR_APOSTA.HORLIM, HOR_APOSTA.HORSOR, HOR_APOSTA.DESHOR, 
                    LOTERIAS.DESLOT, LOTERIAS.ABRLOT, 
                    TIPO_APOSTA.DESTIPOAPO, 
                    COLOCACOES.DESCOL, 
                    VEN_O.NOMVEN AS NOMVEM_O, 
                    APOSTA_PALPITES.VLRPALP, APOSTA_PALPITES.PALP1, APOSTA_PALPITES.PALP2, APOSTA_PALPITES.PALP3,  
                              APOSTA_PALPITES.PALP4, APOSTA_PALPITES.PALP5, APOSTA_PALPITES.PALP6, 
                              APOSTA_PALPITES.PALP7, APOSTA_PALPITES.PALP8, APOSTA_PALPITES.PALP9, 
                              APOSTA_PALPITES.PALP10, APOSTA_PALPITES.PALP11, APOSTA_PALPITES.PALP12, 
                              APOSTA_PALPITES.PALP13, APOSTA_PALPITES.PALP14, APOSTA_PALPITES.PALP15, 
                              APOSTA_PALPITES.PALP16, APOSTA_PALPITES.PALP17, APOSTA_PALPITES.PALP18, 
                              APOSTA_PALPITES.PALP19, APOSTA_PALPITES.PALP20, APOSTA_PALPITES.PALP21, 
                              APOSTA_PALPITES.PALP22, APOSTA_PALPITES.PALP23, APOSTA_PALPITES.PALP24, 
                              APOSTA_PALPITES.PALP25, 
                              APOSTA_PALPITES.VLRPALP AS AP_VLRPALP, APOSTA_PALPITES.VLRPRESEC AS AP_VLRPRESEC, 
                              APOSTA_PALPITES.VLRPREMOL AS AP_VLRPREMOL, APOSTA_PALPITES.VLRPRESMJ AS AP_VLRPRESMJ, 
                              APOSTA_PALPITES.VLRPALPF AS AP_VLRPALPF, APOSTA_PALPITES.VLRPALPD AS AP_VLRPALPD, APOSTA_PALPITES.IDLOT, APOSTA_PALPITES.IDHOR, 
                              APOSTA_PALPITES.VLRCOTACAO AS AP_VLRCOTACAO, 
                              VEN_TIPO_APO.VLRLIMDESC 
                              FROM APOSTA_DESCARGA 
                              INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = APOSTA_DESCARGA.IDBASED AND 
                                                     VENDEDOR.IDVEN  = APOSTA_DESCARGA.IDVEND 
                              INNER JOIN VENDEDOR VEN_O ON VEN_O.IDBASE = APOSTA_DESCARGA.IDBASEO AND 
                                                           VEN_O.IDVEN  = APOSTA_DESCARGA.IDVENO   
                              INNER JOIN APOSTA_PALPITES ON APOSTA_PALPITES.IDBASE  = APOSTA_DESCARGA.IDBASE AND 
                                                            APOSTA_PALPITES.IDVEN   = APOSTA_DESCARGA.IDVEN AND 
                                                            APOSTA_PALPITES.IDREVEN = APOSTA_DESCARGA.IDREVEN AND 
                                                            APOSTA_PALPITES.IDTER   = APOSTA_DESCARGA.IDTER AND 
                                                            APOSTA_PALPITES.IDAPO   = APOSTA_DESCARGA.IDAPO AND 
                                                            APOSTA_PALPITES.NUMPULE = APOSTA_DESCARGA.NUMPULE AND 
                                                            APOSTA_PALPITES.SEQPALP = APOSTA_DESCARGA.SEQPALP 
                              INNER JOIN HOR_APOSTA ON HOR_APOSTA.IDLOT = APOSTA_PALPITES.IDLOT AND 
                                                         HOR_APOSTA.IDHOR = APOSTA_PALPITES.IDHOR 
                              INNER JOIN LOTERIAS ON LOTERIAS.IDLOT = APOSTA_PALPITES.IDLOT 
                              INNER JOIN TIPO_APOSTA ON TIPO_APOSTA.IDTIPOAPO = APOSTA_PALPITES.IDTIPOAPO 
                              INNER JOIN COLOCACOES ON COLOCACOES.IDCOL = APOSTA_PALPITES.IDCOL 
                              INNER JOIN VEN_TIPO_APO ON VEN_TIPO_APO.IDBASE = VEN_O.IDBASE AND 
                                                          VEN_TIPO_APO.IDVEN = VEN_O.IDVEN AND 
                                                          VEN_TIPO_APO.IDTIPOAPO = APOSTA_PALPITES.IDTIPOAPO 
                              WHERE 
                                  APOSTA_DESCARGA.IDBASE <> 999999 
                                  AND APOSTA_DESCARGA.SITDES <> 'CAN' 
                                  AND APOSTA_DESCARGA.VLRPALP > 0
                          
                                  ORDER BY HOR_APOSTA.HORSOR, APOSTA_DESCARGA.VLRPALP DESC
        ");


dd($data);
        return $data;
    }
}
