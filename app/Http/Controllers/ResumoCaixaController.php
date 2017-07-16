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

            "SELECT REVENDEDOR.NOMREVEN, REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN,
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
     
     AND REVENDEDOR.IDBASE = $cod_idbase "

        );


        return $data;
    }

    public function retornaResumoCaixaParameter(){

        //referente aos IDEVEN ??verificar com Douglas??
        $valor = $this->request->get('sel_vendedor');

        //Construi a string com base no array do select via form
        $p = implode(",", $valor);



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

        $cod_idven =  $this->retornaBasesPadrao($codigo);

        $data = DB::select (

            "SELECT REVENDEDOR.NOMREVEN, REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN,
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
     
     AND VENDEDOR.IDEVEN in ($p)"

        );


        return $data;
    }


    public function retornaBasesPadrao($id){


        $data = $this->usuario_ven

            ->where([
                ['idusu', '=', $id],
                ['inpadrao', '=', 'SIM']
            ])
            ->first();


        return $data->idven;
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


}
