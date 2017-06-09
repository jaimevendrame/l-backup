<?php

namespace lotecweb\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use lotecweb\Usuario;



class TestController extends StandardController
{
    private $usuario, $request;

    public function __construct(Usuario $usuario, Request $request)
    {
        $this->usuario = $usuario;
        $this->request = $request;
    }


    public function test()
    {
        $user = $this->idusu_logado;
        dd($user);
    }


}