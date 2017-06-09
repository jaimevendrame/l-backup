<?php

namespace lotecweb\Http\Controllers;

use Illuminate\Http\Request;

use lotecweb\Http\Requests;
use lotecweb\User;
use lotecweb\Models\Usuario;
use lotecweb\Models\Usuario_ven;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;


class StandardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;
    protected $totalPorPagina = 15;

    private $user, $usuario, $usuario_ven;

    public $idusu_logado;

    public function __construct(
        User $user,
        Usuario $usuario,
        Usuario_ven $usuario_ven,

        Request $request)
    {

        $this->user = $user;
        $this->usuario = $usuario;
        $this->usuario_ven = $usuario_ven;
        $this->request = $request;

    }



    public function index()
    {
//        $data = $this->model->paginate($this->totalPorPagina);
//
//        return view("{$this->nameView}.index",compact('data'));

       $idusu_logado = Auth::user()->idusu;
       return $idusu_logado;
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

    public function retonarIDUSU(){

    }
}
