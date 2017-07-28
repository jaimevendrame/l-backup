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

class ResumoCaixaController extends StandardController
{
    protected $model;
    protected $nameView = 'dashboard.resumocaixa';
    protected $data;
    protected $title = 'Resumo Geral por Revendedor';
    protected $redirectCad = '/admin/contatos/cadastrar';
    protected $redirectEdit = '/admin/contatos/editar';
    protected $route = '/admin/contatos';
    public $data_inicial;
    public $data_fim;

    public function __construct(
        Usuario $usuario,
        Usuario_ven $usuario_ven,
        Request $request)
    {
        $this->request = $request;
        $this->usuario = $usuario;
        $this->usuario_ven = $usuario_ven;


    }

    public function index()
    {


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $data = $this->retornaResumoCaixa();

//        dd($data);

        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);

//        dd($baseAll);




        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll'));
    }

    public function indexGo()
    {


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $data = $this->retornaResumoCaixaParameter();

//        dd($data);

        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);




        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll'));
    }

    public function retornaResumoCaixa(){


        $datIni = date ("Y/m/d");
        $datFim = date ("Y/m/d");

        $this->data_inicial = $datIni;
        $this->data_fim = $datFim;

        //data atual menos um dia
//        $inicio = date ("Y/m/d"); // data atual menos um dia
        $inicio = $datIni; // data inicio menos um dia
        $parcelas = 1;
        $data_termino = new DateTime($inicio);
        $data_termino->sub(new DateInterval('P'.$parcelas.'D'));
        $datAnt = $data_termino->format('Y/m/d');

//        dd($datAnt);



        $codigo = Auth::user()->idusu;

        $cod_idbase =  $this->retornaBasesPadrao($codigo);

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
     
     AND VENDEDOR.IDEVEN = $cod_idbase 
     
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

        //referente aos IDEVEN ??verificar com Douglas??
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

            ->where([
                ['idusu', '=', $id],
                ['inpadrao', '=', 'SIM']
            ])
            ->first();


        return $data->ideven;
    }


    public function retornaBasesAll($id){


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

}
