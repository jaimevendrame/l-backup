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

class RevendedorController extends StandardController
{
    protected $model;
    protected $nameView = 'dashboard.revendedor';
    protected $data;
    protected $title = 'Revendedores';
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

        $idusu = Auth::user()->idusu;

        $vendedores = $this->retornaBasesUser($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $title = $this->title;

        //RETORNA SQL REVENDEDOR -> INDEX
        $data = $this->returnIndex($ideven);

        $ideven_default = $this->returnWebControlData($idusu);


        return view("{$this->nameView}",compact('idusu',
            'vendedores', 'menus', 'categorias', 'data','title', 'baseAll', 'ideven','ideven_default'));
    }



public function createRevendedor($ideven){

    $idusu = Auth::user()->idusu;

    $vendedores = $this->retornaBasesUser($idusu);

    $menus = $this->retornaMenu($idusu);

    $categorias = $this->retornaCategorias($menus);

    $title = $this->title;

    $ideven_default = $this->returnWebControlData($idusu);

    $this->nameView = 'dashboard.revendedor-create';

    $bases = $this->retornaBases($idusu);

    $cobrador = $this->retornaCobrador($ideven);

    $ideven = $ideven;


    $baseAll = $this->retornaBasesAll($idusu);


    $valores = $baseAll;




    foreach ($valores as $val){

        if ($val->ideven == $ideven_default) {
            $baseNome  = $val->nombas;
            $idbase = $val->idbase;
            $vendedorNome = $val->nomven;
            $idvendedor = $val->idven;
        }
    }



    return view("{$this->nameView}",compact('idusu',
         'vendedores', 'menus', 'categorias', 'data','title', 'baseAll', 'ideven', 'ideven_default', 'bases', 'cobrador','baseNome', 'idbase', 'vendedorNome', 'idvendedor'));
}
    /**
     * @return mixed
     */



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



    //principal

    public function returnIndex($ideven){



        $valor = $this->retornaAdmin();

//        dd($valor);

        if ($valor != 'SIM'){
            $p = $this->retornaBasepeloIdeven($ideven);

            $data = DB::select(" 
                   SELECT REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN, REVENDEDOR.NOMREVEN,
                    REVENDEDOR.CIDREVEN, REVENDEDOR.SIGUFS, REVENDEDOR.SITREVEN, REVENDEDOR.IDEREVEN,
                    VENDEDOR.NOMVEN
                    FROM REVENDEDOR
                    INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = REVENDEDOR.IDBASE AND
                    VENDEDOR.IDVEN = REVENDEDOR.IDVEN
                    INNER JOIN BASE ON BASE.IDBASE = REVENDEDOR.IDBASE
                    WHERE
                    REVENDEDOR.IDREVEN <> 99999999
                    AND REVENDEDOR.IDBASE = '$p->idbase'
                    AND REVENDEDOR.IDVEN = '$p->idven'
        ");
        } else {
            $data = DB::select(" 
                   SELECT REVENDEDOR.IDBASE, REVENDEDOR.IDVEN, REVENDEDOR.IDREVEN, REVENDEDOR.NOMREVEN,
                    REVENDEDOR.CIDREVEN, REVENDEDOR.SIGUFS, REVENDEDOR.SITREVEN, REVENDEDOR.IDEREVEN,
                    VENDEDOR.NOMVEN
                    FROM REVENDEDOR
                    INNER JOIN VENDEDOR ON VENDEDOR.IDBASE = REVENDEDOR.IDBASE AND
                    VENDEDOR.IDVEN = REVENDEDOR.IDVEN
                    INNER JOIN BASE ON BASE.IDBASE = REVENDEDOR.IDBASE
                    WHERE
                    REVENDEDOR.IDREVEN <> 99999999
        ");

        }



        return $data;
    }

    public function retornaCobrador($ideven){

        $valor = $this->retornaAdmin();

        if ($valor != 'SIM') {
            $p = $this->retornaBasepeloIdeven($ideven);

            $data = DB::select(" 
                   SELECT COBRADOR.IDBASE, COBRADOR.IDVEN, COBRADOR.IDCOBRA, COBRADOR.NOMCOBRA
                  FROM COBRADOR
                   WHERE
                     COBRADOR.IDBASE = '$p->idbase'AND
                     COBRADOR.IDVEN = '$p->idven' AND
                     COBRADOR.SITCOBRA = 'ATIVO'
                     
                     ORDER BY COBRADOR.NOMCOBRA
        ");
        } else {
            $data = DB::select(" 
                   SELECT COBRADOR.IDBASE, COBRADOR.IDVEN, COBRADOR.IDCOBRA, COBRADOR.NOMCOBRA
                  FROM COBRADOR
                   WHERE
                     COBRADOR.SITCOBRA = 'ATIVO'
                     ORDER BY COBRADOR.NOMCOBRA
            ");
        }

         return $data;
    }

    public function retornaBase($idbase){
        $data = DB::select(" 
                   SELECT IDBASE,NOMPRO,NOMBAS,CIDBAS,SIGUFS
                   FROM BASE
                    WHERE SITBAS = 'ATIVO'
                    AND IDBASE = '$idbase'
            ");
        return $data;

    }

    public function retornaVend($idbase, $idven){
        $data = DB::select(" 
                   SELECT IDBASE,IDVEN,NOMVEN,APEVEN,CIDVEN,SIGUFS,PORTA_COM,IN_IMPAPO,IN_CANAPO,IN_IMPDIRETA
                    FROM VENDEDOR
                    WHERE SITVEN = 'ATIVO' AND
                    IDBASE = '$idbase'
                    AND VENDEDOR.IDVEN = '$idven'
            ");
        return $data;

    }

    public function createRevendedorGo()
    {
        $dataForm = $this->request->all();
        /** @var $rules */
        $rules = [
            'idbase'    => 'required',
            'idven'     => 'required',
            'nomreven'  => 'required|min:3|max:255',
            'cidreven'  => 'required|min:3|max:255',
            'sigufs'    => 'required',
            'limcred'   => 'required',
            'vlrcom'    => 'required',
            'vlrmaxpalp'=> 'required',
            'vlrblopre' => 'required',
            'limlibpre' => 'required',
            'limlibpre' => 'required',
            'sitreven'  => 'required',
//            'endreven'  => 'required|min:3|max:255',
//            'baireven'  => 'required|min:3|max:255',
//            'celreven'  => 'required|min:14|max:14',
//            'insolaut'  => 'required',
//            'idcobra'   => 'required',
//            'porta_com' => 'required|min:3|max:255',
//            'datcad'    => 'required',
//            'in_impapo' => 'required',
//            'idusucad'  => 'required',
//            'in_canapo' => 'required',
//            'datalt'    => 'required',
//            'loctrab'   => 'required|min:3|max:255',
        ];

        $required = 'é uma campo obrigatório';
        $min = 'deve ter no mínimo 3 caracteres';
        $max = 'deve ter no máximo 255 caracteres';
        $numeric = 'é um campo númerico';

        /** @var $mensagens */
        $mensagens = [
            'nomreven.required'     => "NOME {$required}",
            'nomreven.min'          => "NOME {$min}",
            'nomreven.max'          => "NOme {$max}",
            'cidreven.required'     => "CIDADE {$required}",
            'cidreven.min'          => "CIDADE {$min}",
            'cidreven.max'          => "CIDADE {$max}",
            'sigufs.required'       => "UF {$required}",
            'limcred.required'      => "LIMITE DE CRÉDITO {$required}",
            'limcred.NUMERIC'       => "LIMITE DE CRÉDITO {$numeric}",
            'vlrcom.required'       => "COMISSÃO PADRÃO {$required}",
            'vlrcom.numeric'        => "COMISSÃO PADRÃO {$numeric}",
            'vlrmaxpalp.required'   => "VLR. MÁXIMO P/ PALPITE {$required}",
            'vlrmaxpalp.numeric'    => "VLR. MÁXIMO P/ PALPITE {$numeric}",
            'vlrblopre.required'    => "BLOQUEAR PRÊMIO MAIOR QUE {$required}",
            'vlrblopre.numeric'     => "BLOQUEAR PRÊMIO MAIOR QUE {$numeric}",
            'limlibpre.required'    => "LIMITE DE DIAS PARA PRÊMIO {$required}",
            'limlibpre.numeric'     => "LIMITE DE DIAS PARA PRÊMIO {$numeric}",
            'endreven.required'     => "ENDEREÇO {$required}",
            'endreven.min'          => "ENDEREÇO {$min}",
            'endreven.max'          => "ENDEREÇO {$max}",
            'baireven.required'     => "BAIRRO {$required}",
            'baireven.min'          => "BAIRRO {$min}",
            'baireven.max'          => "BAIRRO {$max}",
            'celreven.required'     => "CELULAR {$required}",
            'idcobra.required'      => "COBRADOR {$required}",
            'porta_com.required'    => "PORTA COMUNICAÇÃO {$required}",
            'datcad.required'       => "DATA DE CADASTRO {$required}",
            'datalt.required'       => "DATA DE ALTERAÇÃO {$required}",
            'loctrab.required'       => "LOCAL DO TRABALHO {$required}",


        ];

        /** validação do request */
        $this->validate($this->request, $rules, $mensagens);

        $idbase = $this->request->input('idbase');
        $idven = $this->request->input('idven');
        $idereven = $this->request->input('idereven');
        $nomreven = $this->request->input('nomreven');
        $cidreven = $this->request->input('cidreven');
        $sigufs = $this->request->input('sigufs');
        $limcred = $this->request->input('limcred');
        $vlrcom = $this->request->input('vlrcom');
        $vlrmaxpalp = $this->request->input('vlrmaxpalp');
        $vlrblopre = $this->request->input('vlrblopre');
        $limlibpre = $this->request->input('limlibpre');
        $sitreven = $this->request->input('sitreven');
        $idreven = $this->request->input('idreven');
        $endreven = $this->request->input('endreven');
        $baireven = $this->request->input('baireven');
        $celreven = $this->request->input('celreven');
        $obsreven = $this->request->input('obsreven');
        $insolaut = $this->request->input('insolaut');
        $idcobra = $this->request->input('idcobra');
        $porta_com = $this->request->input('porta_com');
        $datcad = $this->request->input('datcad');
        $in_impapo = $this->request->input('in_impapo');
        $idusucad = $this->request->input('idusucad');
        $in_canapo = $this->request->input('in_canapo');
        $datalt = $this->request->input('datalt');
        $in_impdireta = $this->request->input('in_impdireta');
        $idusualt = $this->request->input('idusualt');
        $loctrab = $this->request->input('loctrab');


//        dd($datcad);

        if ($datcad != ''){
            $dataCadastro = new DateTime();
            $newDateInicial = $dataCadastro->createFromFormat('d/m/Y', $datcad);
            $datcad = $newDateInicial->format('Y/m/d');
        }


        if ($datalt != ''){
            $dataAlteracao = new DateTime();
            $newDateInicial = $dataAlteracao->createFromFormat('d/m/Y', $datalt);
            $datalt = $newDateInicial->format('Y/m/d');
        }


        $idreven = $this->returnRevendedor($idbase, $idven);
        $idereven = $this->returnIdReven();
        $idusualt = 1000;

        $dados_array = [

            "idbase" => $idbase,
            "idven" => $idven,
            "idereven" => $idereven,
            "nomreven" => strtoupper($nomreven),
            "cidreven" => strtoupper($cidreven),
            "sigufs" => $sigufs,
            "limcred" => floatval(str_replace(',', '.', $limcred)),
            "vlrcom" => floatval(str_replace(',', '.', $vlrcom)),
            "vlrmaxpalp" => floatval(str_replace(',', '.', $vlrmaxpalp)),
            "vlrblopre" => floatval(str_replace(',', '.', $vlrblopre)),
            "limlibpre" => floatval(str_replace(',', '.', $limlibpre)),
            "sitreven" => $sitreven,
            "idreven" => $idreven,
            "endreven" => strtoupper($endreven),
            "baireven" => strtoupper($baireven),
            "celreven" => $celreven,
            "obsreven" => strtoupper($obsreven),
            "insolaut" => $insolaut,
            "idcobra" => $idcobra,
            "porta_com" => $porta_com,
            "datcad" => $datcad,
            "in_impapo" => $in_impapo,
            "idusucad" => $idusucad,
            "in_canapo" => $in_canapo,
            "datalt" => $datalt,
            "in_impdireta" => $in_impdireta,
            "idusualt" => $idusualt,
            "loctrab" => $loctrab,

        ];

//        dd($dados_array);

        $insert = DB::table('REVENDEDOR')->insert($dados_array);



        if($insert)
            return redirect()
                ->route("{$this->route}.index")
                ->with(['success'=>'Cadastro realizado com sucesso!']);
        else
            return redirect()
                ->route("revendedor-create")
                ->withErrors(['errors' => 'Falha ao cadastrar'])
                ->withInput();


    }

    public function  returnRevendedor($idbase, $idven){

        $data = DB::select (" 
        SELECT MAX(REVENDEDOR.IDREVEN) AS IDREVEN
                  FROM REVENDEDOR
                  WHERE
                  REVENDEDOR.IDBASE = '$idbase' AND
                  REVENDEDOR.IDVEN = '$idven' 

        ");

        $data = $data[0]->idreven;

        $data = $data + 1;

        return $data;
    }

    public function returnIdReven(){
        $data = DB::select (" 
        SELECT MAX(REVENDEDOR.IDEREVEN) AS IDEREVEN
                  FROM REVENDEDOR 

        ");
        $data = $data[0]->idereven;

        $data = $data + 1;

        return $data;
    }


    
}
