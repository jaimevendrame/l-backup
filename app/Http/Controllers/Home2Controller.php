<?php

namespace lotecweb\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use lotecweb\Http\Requests;
use lotecweb\Models\Revendedor;
use lotecweb\Models\Usuario;
use lotecweb\Models\ResumoCaixa;
use lotecweb\Models\Usuario_ven;
use lotecweb\User;

class Home2Controller extends StandardController
{
    protected $model;
    protected $nameView = 'home';
    protected $data;
    protected $title = 'Dashboard';
    protected $redirectCad = '/admin/contatos/cadastrar';
    protected $redirectEdit = '/admin/contatos/editar';
    protected $route = '/admin/contatos';

    public function __construct(
        User $user,
        Usuario $usuario,
        Revendedor $revendedor,
        ResumoCaixa $resumocaixa,
        Usuario_ven $usuario_ven,

        Request $request)
    {
        $this->user = $user;
        $this->request = $request;
        $this->usuario = $usuario;
        $this->revendedor = $revendedor;
        $this->resumocaixa = $resumocaixa;
        $this->model = $this->retornaResumoCaixa();
        $this->usuario_ven = $usuario_ven;




    }

    public function indexGo(){
        $select_ideven = $this->request->get('select_ideven');

        // Criar uma sessão
        $cart = $select_ideven ;
        session(['cart' => $cart]);

        // Recuperar
        $cart = session('cart');

        return $select_ideven;

    }

    public function retornaResumoCaixa(){


        $datIni = '2017/07/07';
        $datFim = '2017/07/07';
        $datAnt = '2017/07/07';

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
     REVENDEDOR.IDREVEN <> 99999999"

        );

//        dd($data);

        return $data;

    }




}
