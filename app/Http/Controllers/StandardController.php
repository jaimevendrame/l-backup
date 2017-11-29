<?php

namespace lotecweb\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use lotecweb\Http\Requests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;
use lotecweb\Models\Cobrador;
use lotecweb\Models\Revendedor;
use lotecweb\Models\Usuario;
use lotecweb\Models\Usuario_ven;
use lotecweb\Models\Vendedor;
use lotecweb\User;


class StandardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;
    protected $totalPorPagina = 15;

    public function __construct(

        Usuario $usuario,
        User $user,
        Revendedor $revendedor,
        Vendedor $vendedor,
        Cobrador $cobrador,
        Usuario_ven $usuario_ven,
        Request $request


    )
    {

        $this->request = $request;
        $this->usuario = $usuario;
        $this->user = $user;
        $this->revendedor = $revendedor;
        $this->vendedor = $vendedor;
        $this->cobrador = $cobrador;
        $this->usuario_ven = $usuario_ven;



    }

    public function index()
    {


        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

//        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $vendedores = $this->retornaBasesAll($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

//        $data = $this->model;

        $title = $this->title;

        $admin = Usuario::where('idusu', '=', $idusu)->first();

        if ($admin->inadim != 'SIM'){
            $validaMesalidade = $this->validarMensalidade($idusu);
        }






        return view("{$this->nameView}",compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'validaMesalidade'));
    }



    public function delete($id)
    {
        $item = $this->model->find($id);

        $deleta = $item->delete();

        return redirect($this->route);
    }

    public function pesquisar()
    {
        $palavraPesquisa = $this->request->get('pesquisar');

        $data = $this->model->where('nome', 'LIKE', "%$palavraPesquisa%")->paginate(10);

        return view("{$this->nameView}.index", compact('data'));
    }

    public function retornaBase($idUsu){

        //retorna apenas o primeiro registro

        $data = DB::table('USUARIO_BASE')
            ->select('USUARIO_BASE.*', 'USUARIO_BASE.IDBASE AS PIVOT_IDBASE')
            ->join('BASE', 'USUARIO_BASE.IDBASE','=','BASE.IDBASE')
            ->where('USUARIO_BASE.IDUSU', '=', $idUsu)
            ->first();
        return $data;
    }

    public function retornaBases($idUsu){

        $data = DB::table('USUARIO_BASE')
            ->select('USUARIO_BASE.*','BASE.*')
            ->join('BASE', 'USUARIO_BASE.IDBASE','=','BASE.IDBASE')
            ->join('USUARIO', 'USUARIO_BASE.IDUSU', '=', 'USUARIO.IDUSU')
            ->where('USUARIO_BASE.IDUSU', '=', $idUsu)
            ->get();

        //pegar do usuarioven

        return $data;
    }

    public function retornaUserLotec($idUsu){
        $data = $this->usuario
            ->where('idusu', '=', $idUsu)
            ->first();

        return $data;
    }
    public function retornaUsuarioVen($idUsu, $idBase){
        //retorna o vendedor viculado ao usuario e a base
        dd($idBase);

        if ((!empty($idUsu)) && (!empty($idBase))){
            $data = DB::table('USUARIO_VEN')
                ->select('USUARIO_VEN.*', 'VENDEDOR.NOMVEN', 'VENDEDOR.IDVEN as PIVOT_IDVEN')
                ->join('VENDEDOR', 'USUARIO_VEN.IDVEN', '=', 'VENDEDOR.IDVEN')
                ->join('USUARIO', 'USUARIO_VEN.IDUSU', '=', 'USUARIO.IDUSU')
                ->where([
                    ['USUARIO_VEN.IDUSU', '=', $idUsu],
                    ['VENDEDOR.IDBASE', '=', $idBase]
                ])->get();

            return $data;

        } else {
            return 1;
        }



    }

    public function gerarUser(){
        $usuario_lotec = $this->usuario->get();


        foreach ($usuario_lotec as $ul){

//            dd($ul->idusu);

            $insert =  $this->user->create([
                'name' => $ul->logusu,
                'email' => strtolower(str_replace(" ","",$ul->logusu)).'@lotec.com',
                'password' => bcrypt($ul->senusu),
                'idusu' => $ul->idusu,
                'role' => \lotecweb\User::ROLE_ADMIN,

            ]);

            if ($insert)

                echo strtolower(trim($ul->logusu))."@lotec.com - OK! <br>";

            else
                return strtolower(trim($ul->logusu))."@lotec.com - Falha! <br>";
        }


    }

    public function retornaMenu($idUsu){
        $menus = DB::table('MENU_ACTION')
            ->join('USUARIO_MENU_ACTION', 'MENU_ACTION.IDACT', '=', 'USUARIO_MENU_ACTION.IDACT')
            ->where([
                ['USUARIO_MENU_ACTION.IDUSU', '=', $idUsu],
                ['USUARIO_MENU_ACTION.INLIB', '=', 'SIM'],
                ['MENU_ACTION.INWEB', '=', 'SIM'],
            ])
            ->orderBy('MENU_ACTION.CATACT', 'asc')
            ->get();


        return $menus;
    }

    public function retornaCategorias($menus){

        $categorias = array();

        $cat = '';

        foreach($menus as $data)
        {
            if($cat == $data->catact)
            {} else {
                $categorias[] = $data->catact;
                $cat = $data->catact;
            }
        }


        return $categorias;
    }

    public function loadData(){

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

    public function addUserWeb(){
        $usuario_lotec = $this->usuario->get();

        return view('dashboard.admin.index', compact('usuario_lotec'));
    }


    public function retornaRevendedor($id){


        $idbase = $this->retornaBasepeloIdeven($id);

//        dd($idbase->idbase);

        $data = $this->revendedor
            ->where('idbase','=',$idbase->idbase)
            ->orderby('nomreven')
            ->get();

        return $data;

    }

    public function retornaBasepeloIdeven($ideven){
        $data = $this->vendedor
            ->where('ideven','=', $ideven)
            ->first();

        return $data;
    }

    public function retornaCobrador($id){

        $id = $this->retornaBasepeloIdeven($id);

        $data = $this->cobrador
            ->select('idbase', 'idven', 'idcobra', 'nomcobra')
            ->where([
                ['sitcobra', '=', 'ATIVO'],
                ['idbase', '=', $id->idbase],
                ['idven', '=', $id->idven]
            ])
            ->orderby('nomcobra')
        ->get();

        return $data;
    }

    public function returnUsuarioDesktop(){

        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaBasesAll($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $title = 'Manager Usuário Desktop';



        $inadmin = $this->usuario
            ->where('idusu', '=', $idusu)
            ->first();
        if ($inadmin->inadim == "SIM"){
            $data = $this->usuario->all();
            $path = "dashboard.admin.usuario";
        } else {
            $data = "";
            $path = "errors.403";
        }

        return view("$path", compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title'));
    }


    public function returnUsuarioWeb(){

        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaBasesAll($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $title = 'Manager Usuário Web';

        $inadmin = $this->usuario
            ->where('idusu', '=', $idusu)
            ->first();
        if ($inadmin->inadim == "SIM"){
            $data = $this->user->all();
            $path = "dashboard.admin.uweb";
        } else {
            $data = "";
            $path = "errors.403";
        }


        return view("$path", compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title'));
    }

    public function createUsuarioWeb($id){

        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);

        $vendedores = $this->retornaBasesAll($idusu);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

        $title = 'Criar Usuário Web';








        $inadmin = $this->usuario
            ->where('idusu', '=', $idusu)
            ->first();
        if ($inadmin->inadim == "SIM"){
            $data = $this->usuario
                ->where('idusu', '=', $id)
                ->first();

            $usuarioWeb = $this->user
                ->where('idusu', '=', $id)
                ->first();

            $path = "dashboard.admin.createuweb";
        } else {
            $data = "";
            $usuarioWeb = "";
            $path = "errors.403";
        }

        return view("$path", compact('idusu',
            'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias', 'data','title', 'usuarioWeb'));
    }


    public function updateUsuarioWeb(){

        $dadosForm = $this->request->all();
        $idusu = $this->request->get('idusu');
        $id = $this->request->get('id');

        $validator = validator($dadosForm, $this->user->rulesEdit);

        if ($validator->fails()) {

            return redirect("/admin/manager/web/create/$idusu")
                ->withErrors($validator)
                ->withInput();
        }

        $item = $this->user->find($id);

        $dadosForm['password'] = bcrypt($dadosForm['password']);

        $update = $item->update($dadosForm);

        if ($update)

            return redirect("/admin/manager/desktop/");

        else
            return redirect("/admin/manager/web/create/$id")
                ->withErrors(['errors'=> 'Falha ao Editar'])
                ->withInput();
    }

    public function insertUsuarioWeb(){


        $dadosForm = $this->request->all();

        dd($dadosForm);
        $idusu = $this->request->get('idusu');
        $id = $this->request->get('id');

        $validator = validator($dadosForm, $this->user->rulesEdit);

        if ($validator->fails()) {

            return redirect("/admin/manager/web/create/$idusu")
                ->withErrors($validator)
                ->withInput();
        }


        $dadosForm['password'] = bcrypt($dadosForm['password']);

        $insert = $this->user->create($dadosForm);

        if ($insert)

            return redirect("/admin/manager/desktop/");

        else
            return redirect("/admin/manager/web/create/$id")
                ->withErrors(['errors'=> 'Falha ao Editar'])
                ->withInput();
    }
    public function WebGo(){


        $dadosForm = $this->request->all();

        dd($dadosForm);


    }

    public function validarMensalidade($idusu){

        $p = $this->returnBaseIdvenDefault($idusu);
         $d = date ("Y-m-d");

        $data = DB::table('cobranca')
                    ->select('datven','datpro' )
                    ->where([
                        ['idbase','=', $p->idbase],
                        ['idven', '=', $p->idven],
                        ['sitcob', '=', 'ABERTO']
                    ])
                    ->orderby('idcob','asc')
                    ->first();

        return $data;
    }

    public function returnBaseIdvenDefault($idusu){



        $data = DB::table('usuario_ven')
                    ->where([
                        ['inpadrao', '=', 'SIM'],
                        ['idusu', '=', $idusu]
                    ])
            ->first();

        return $data;
    }


    public function webinsertGo($id){

        $data = $this->usuario
            ->where('idusu', '=', $id)
            ->first();


        return $data;
    }


}
