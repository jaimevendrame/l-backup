<?php

namespace lotecweb\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use lotecweb\Models\Aluno;
use lotecweb\Models\Movimento_caixa;
use lotecweb\User;
use lotecweb\Models\Usuario;
use lotecweb\Models\Usuario_ven;
use lotecweb\Models\Base;

class HomeController extends Controller
{

    private $user, $usuario, $usuario_ven, $base, $request;


    public function __construct(
        User $user,
        Usuario $usuario,
        Usuario_ven $usuario_ven,
        Movimento_caixa $movimento_caixa,
        Base $base,
        Request $request)
    {
        $this->user = $user;
        $this->request = $request;
        $this->usuario = $usuario;
        $this->usuario_ven = $usuario_ven;
        $this->movimento_caixa = $movimento_caixa;
        $this->base = $base;


    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idusu = Auth::user()->idusu;

        $user_base = $this->retornaBase($idusu);

        $user_bases = $this->retornaBases($idusu);

        $usuario_lotec = $this->retornaUserLotec($idusu);


        $vendedores = $this->retornaUsuarioVen($idusu, $user_base->pivot_idbase);

        $menus = $this->retornaMenu($idusu);

        $categorias = $this->retornaCategorias($menus);

//        dd($menus);



        return view('home',compact('idusu', 'user_base', 'user_bases', 'usuario_lotec', 'vendedores', 'menus', 'categorias'));
    }

    public function delete($idAluno){

        $alunos = Aluno::find($idAluno);
        $alunos->delete();

        return redirect('admin/home');

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
        //retorna todas bases do usuário
//        $data = DB::select( 'SELECT * FROM USUARIO_BASE
//                              INNER JOIN BASE ON USUARIO_BASE.IDBASE = BASE.IDBASE
//                              INNER JOIN USUARIO ON USUARIO_BASE.IDUSU = USUARIO.IDUSU
//                              WHERE USUARIO_BASE.IDUSU = :idUsu', ['USUARIO_BASE.idUsu' => $idUsu] );

        $data = DB::table('USUARIO_BASE')
            ->select('USUARIO_BASE.*','BASE.*')
            ->join('BASE', 'USUARIO_BASE.IDBASE','=','BASE.IDBASE')
            ->join('USUARIO', 'USUARIO_BASE.IDUSU', '=', 'USUARIO.IDUSU')
            ->where('USUARIO_BASE.IDUSU', '=', $idUsu)
            ->get();

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
                'name' => $ul->nomusu,
                'email' => strtolower(str_replace(" ","",$ul->nomusu)).'@lotec.com',
                'password' => bcrypt($ul->senusu),
                'idusu' => $ul->idusu,
                'role' => \lotecweb\User::ROLE_ADMIN,

            ]);

            if ($insert)

                echo strtolower(trim($ul->nomusu))."@lotec.com - OK! <br>";

            else
                return strtolower(trim($ul->nomusu))."@lotec.com - Falha! <br>";
        }


    }

    public function retornaMenu($idUsu){
      $menus = DB::table('MENU_ACTION')
          ->join('USUARIO_MENU_ACTION', 'MENU_ACTION.IDACT', '=', 'USUARIO_MENU_ACTION.IDACT')
          ->where('USUARIO_MENU_ACTION.IDUSU', '=', $idUsu)
          ->orderBy('MENU_ACTION.CATACT', 'asc')
          ->get();








//



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






}
