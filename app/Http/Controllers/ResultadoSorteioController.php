<?php

namespace lotecweb\Http\Controllers;

use Carbon\Carbon;
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

class ResultadoSorteioController extends StandardController
{
    protected $model;
    protected $nameView = 'dashboard.resultadosorteio';
    protected $data;
    protected $title = 'Resultado de Sorteio';
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

//        $valor = $this->tudoAqui($ideven);

//        $x = 0;
//        foreach ($valor as $key =>$loteria)
//            if($loteria['idlot'] != $x){
//                echo $loteria['deslot']."<br>";
//                $x = $loteria['idlot'];
//
//
//                foreach ($deslot as $idsort =>$sort)
//                    echo $sort['idsor'];
//            }
//        dd($valor);


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

//        $data = $this->returnLoter($ideven);
        $data = "";
//        dd($data);

        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);

        //datas inicio e fim mês

//        $sorteios = $this->returnSorteio();
//        $sorteioite = $this->returnSorteioIte();
        $linhas = 6;



        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'baseAll', 'ideven', 'sorteios', 'sorteioite', 'linhas', 'valor'));
    }

    public function indexGo($ideven)
    {


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaBasesUser($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);


        $ideven = $ideven;

//        $sorteios = $this->returnSorteio();
//        $sorteioite = $this->returnSorteioIte();

        $linhas = $this->returnColMax($ideven);

        $linhas = $linhas->colmax;
        $col = $linhas;

        $valor = $this->tudoAqui($ideven);


        $title = $this->title;

        $baseAll = $this->retornaBasesAll($idusu);


        $col6 = $this->request->get('col6');
        $col7 = $this->request->get('col7');
        $col8 = $this->request->get('col8');

        if ($col6 != null && $col6 == $col){
            $linhas = $col6;
        }
        if ($col7 != null && $col7 == $col){
            $linhas = $col7;
        }
        if ($col8 != null && $col7 == $col){
            $linhas = $col8;
        }


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

        $p_situacao =  $this->request->get('group1');


                return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'valor','title', 'baseAll','ideven', 'despesas','in_ativos', 'p_situacao', 'linhas'));
    }








    /**
     * @return mixed
     */




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





        //Resultado de Sorteio

        public function returnLoter($ideven){
            $p = $this->retornaBasepeloIdeven($ideven);

            $data = DB::select (" 
            SELECT VEN_LOTERIA.IDBASE, VEN_LOTERIA.IDVEN, VEN_LOTERIA.IDLOT,
            VEN_LOTERIA.SITLIG, VEN_LOTERIA.INAUTO,
            LOTERIAS.DESLOT
            FROM VEN_LOTERIA
            INNER JOIN LOTERIAS ON LOTERIAS.IDLOT = VEN_LOTERIA.IDLOT
            WHERE
            VEN_LOTERIA.sitlig = 'ATIVO' AND
            VEN_LOTERIA.IDBASE = '$p->idbase' AND
            VEN_LOTERIA.IDVEN = '$p->idven'
            ORDER BY LOTERIAS.IDLOT
            
            ");

            return $data;
        }

        public function returnSorteio(){

            $datIni = $this->request->get('datIni');
            if ($datIni == ''){
                $datIni = date ("Y/m/d");
            } else {

                //Converte data inicial de string para Date(y/m/d)
                $datetimeinicial = new DateTime();
                $newDateInicial = $datetimeinicial->createFromFormat('d/m/Y', $datIni);

                $datIni = $newDateInicial->format('Y/m/d');
            }
            $data = DB::select ("
            SELECT SORTEIOS.IDSOR, SORTEIOS.IDLOT, SORTEIOS.IDHOR, SORTEIOS.DESSOR,'$datIni' AS DATAINI,
            SORTEIOS.DEZ1, SORTEIOS.DEZ2, SORTEIOS.DEZ3,SORTEIOS.DEZ4,
            SORTEIOS.DEZ5, SORTEIOS.DEZ6, SORTEIOS.DEZ7,SORTEIOS.DEZ8
            FROM SORTEIOS
            WHERE
            SORTEIOS.DATSOR = '$datIni' 
            AND SORTEIOS.IDBASE = 0
            ORDER BY SORTEIOS.IDSOR
            ");
            return $data;
        }

    public function returnSorteioIte(){
            $data = DB::select ("
            SELECT SORTEIOS_ITE.*
            FROM SORTEIOS_ITE
            ORDER BY SORTEIOS_ITE.SEQSOR ASC     
            ");

            return $data;
    }

    public function returnColMax($ideven){

        $p = $this->retornaBasepeloIdeven($ideven);

        $data = DB::table('VENDEDOR')
            ->select('COLMAX')
            ->where([
                ['IDBASE', '=', $p->idbase],
                ['IDVEN', '=', $p->idven]
            ])
            ->first();

        return $data;
    }

    public function sorteioA($idlot){
        $datIni = $this->request->get('datIni');
        if ($datIni == ''){
            $datIni = date ("Y/m/d");
        } else {

            //Converte data inicial de string para Date(y/m/d)
            $datetimeinicial = new DateTime();
            $newDateInicial = $datetimeinicial->createFromFormat('d/m/Y', $datIni);

            $datIni = $newDateInicial->format('Y/m/d');
        }

        $data = DB::select ("
            SELECT SORTEIOS.IDSOR, SORTEIOS.IDLOT, SORTEIOS.IDHOR, SORTEIOS.DESSOR,
            SORTEIOS.DEZ1, SORTEIOS.DEZ2, SORTEIOS.DEZ3,SORTEIOS.DEZ4,
            SORTEIOS.DEZ5, SORTEIOS.DEZ6, SORTEIOS.DEZ7,SORTEIOS.DEZ8,SORTEIOS.DATSOR
            FROM SORTEIOS
            WHERE
            SORTEIOS.DATSOR = '$datIni' 
            AND SORTEIOS.IDBASE = 0
            AND SORTEIOS.IDLOT = '$idlot'
            ORDER BY SORTEIOS.IDSOR
            ");
        return $data;
    }
    public function returnSorteioIteA($idsor){
        $data = DB::select ("
            SELECT SORTEIOS_ITE.*
            FROM SORTEIOS_ITE
            WHERE
            SORTEIOS_ITE.IDSOR = '$idsor'
            ORDER BY SORTEIOS_ITE.SEQSOR ASC     
            ");

        return $data;
    }
    public function tudoAqui($ideven){

        $loteria = $this->returnLoter($ideven);

        $data = array();

        foreach ($loteria as $key){
//            echo $key->idlot. '-'. $key->deslot. ': ';
            $sorteios = $this->sorteioA($key->idlot);
            foreach ($sorteios as $sort){
//                echo $sort->idsor.' ';
                $sorteioite = $this->returnSorteioIteA($sort->idsor);
                foreach ($sorteioite as $ite){
//                    echo $ite->desseq.' ';
                    $linha = [
                        "idlot" => $key->idlot,
                        "deslot" => $key->deslot,
                        "idsor" => $sort->idsor,
                        "dessor" => $sort->dessor,
                        "datsor" => $sort->datsor,
                        "dez1" => $sort->dez1,
                        "dez2" => $sort->dez2,
                        "dez3" => $sort->dez3,
                        "dez4" => $sort->dez4,
                        "dez5" => $sort->dez5,
                        "dez6" => $sort->dez6,
                        "dez7" => $sort->dez7,
                        "dez8" => $sort->dez8,
                        "seqsor" => $ite->seqsor,
                        "desseq" => $ite->desseq,
                        "milsor" => $ite->milsor,
                        "gru" => $ite->gru,
                        "desgru" => $ite->desgru,
                        "super5" => $ite->super5,
                    ];
                    array_push($data, $linha);
                }

            }

        }

       return $data;
    }

}


