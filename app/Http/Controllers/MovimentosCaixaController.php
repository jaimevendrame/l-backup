<?php

namespace lotecweb\Http\Controllers;

use DateInterval;
use DateTime;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use lotecweb\Http\Requests;
use lotecweb\Models\Cobrador;
use lotecweb\Models\Revendedor;
use lotecweb\Models\Usuario;
use lotecweb\Models\Usuario_ven;
use lotecweb\Models\Vendedor;

class MovimentosCaixaController extends StandardController
{
    protected $model;
    protected $nameView = 'dashboard.movimentoscaixa';
    protected $data;
    protected $title = 'Movimentos de Caixa';
    protected $redirectCad = '/admin/contatos/cadastrar';
    protected $redirectEdit = '/admin/contatos/editar';
    protected $route = '/admin/contatos';
    public $data_inicial;
    public $data_fim;

    public function __construct(
        Usuario $usuario,
        Usuario_ven $usuario_ven,
        Vendedor $vendedor,
        Revendedor $revendedor,
        Cobrador $cobrador,
        Request $request)
    {
        $this->request = $request;
        $this->usuario = $usuario;
        $this->usuario_ven = $usuario_ven;
        $this->vendedor = $vendedor;
        $this->revendedor = $revendedor;
        $this->cobrador = $cobrador;


    }

    public function index2($ideven)
    {

        $reven = $this->retornaRevendedor($ideven);

        $cobrador = $this->retornaCobrador($ideven);

        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

//dd($idusu);

//        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $vendedores = $this->retornaBasesUser($idusu);


        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $data = $this->retornaMovimentosCaixa($ideven);

        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);





        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll', 'reven', 'cobrador'));
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

        if (isset($valor)){
//            $ideven2 = implode(",", $valor);
            $ideven2 = $valor;
        } else{$ideven2 = 0;}


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

    public function retornaMovimentosCaixa($ideven){

        $str_idbase = '';
        $str_idven = '';

        if (Auth::user()->idusu == 1000){
            $idbase = $this->vendedor
                ->select('idbase')
                ->where('ideven', '=', $ideven);

            //retornar o idven

            $str_idbase = "AND MOVIMENTOS_CAIXA.IDBASE = ".$idbase;
            $str_idven = "AND MOVIMENTOS_CAIXA.IDEVEN = ".$ideven ;

        }

        $datIni = date ("Y/m/d");
        $datFim = date ("Y/m/d");

        $this->data_inicial = $datIni;
        $this->data_fim = $datFim;


        $data = DB::select ("
        SELECT MOVIMENTOS_CAIXA.*, REVENDEDOR.NOMREVEN, COBRADOR.NOMCOBRA, '$datIni' AS DATAINI, '$datFim' AS DATAFIM
        FROM MOVIMENTOS_CAIXA
        INNER JOIN REVENDEDOR ON
                  REVENDEDOR.IDBASE = MOVIMENTOS_CAIXA.IDBASE AND
                  REVENDEDOR.IDVEN = MOVIMENTOS_CAIXA.IDVEN AND
                  REVENDEDOR.IDREVEN = MOVIMENTOS_CAIXA.IDREVEN
        LEFT JOIN COBRADOR ON
                  COBRADOR.IDBASE = MOVIMENTOS_CAIXA.IDBASE AND
                  COBRADOR.IDVEN = MOVIMENTOS_CAIXA.IDBASE AND
                  COBRADOR.IDCOBRA = MOVIMENTOS_CAIXA.IDCOBRA
        WHERE 
            MOVIMENTOS_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim'
            
            $str_idbase
            $str_idven
        "

        );

//    dd($data);
        return $data;
    }

    /**
     * @return mixed
     */
    public function retornaResumoCaixaParameter($ideven){

        $str_idbase = '';
        $str_idven = '';

        if (Auth::user()->idusu == 1000){
            $idbase = $this->vendedor
                ->select('idbase')
                ->where('ideven', '=', $ideven);

            //retornar o idven

            $str_idbase = "AND MOVIMENTOS_CAIXA.IDBASE = ".$idbase;
            $str_idven = "AND MOVIMENTOS_CAIXA.IDEVEN = ".$ideven ;

        }

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



        $data = DB::select ("
        SELECT MOVIMENTOS_CAIXA.*, REVENDEDOR.NOMREVEN, COBRADOR.NOMCOBRA, '$datIni' AS DATAINI, '$datFim' AS DATAFIM
        FROM MOVIMENTOS_CAIXA
        INNER JOIN REVENDEDOR ON
                  REVENDEDOR.IDBASE = MOVIMENTOS_CAIXA.IDBASE AND
                  REVENDEDOR.IDVEN = MOVIMENTOS_CAIXA.IDVEN AND
                  REVENDEDOR.IDREVEN = MOVIMENTOS_CAIXA.IDREVEN
        LEFT JOIN COBRADOR ON
                  COBRADOR.IDBASE = MOVIMENTOS_CAIXA.IDBASE AND
                  COBRADOR.IDVEN = MOVIMENTOS_CAIXA.IDBASE AND
                  COBRADOR.IDCOBRA = MOVIMENTOS_CAIXA.IDCOBRA
        WHERE 
            MOVIMENTOS_CAIXA.DATMOV BETWEEN '$datIni' AND '$datFim'
            
            $str_idbase
            $str_idven
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

}
