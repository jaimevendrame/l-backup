<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
//    \Illuminate\Support\Facades\Auth::LoginUsingId(2);
    return redirect()->route('admin.home');
});

//Route::get('/aluno', 'AlunoController@aluno');
//
//Route::get('/add-aluno', 'AlunoController@addAluno');
//Route::post('/add-aluno', 'AlunoController@addAlunoGo');
//
//
//Route::get('/tst/{cell}', 'AlunoController@pesquisar');
//Route::get('/editar-aluno/', 'AlunoController@editar');
//Route::post('/editar-aluno/{id}', 'AlunoController@editarGo');
//
//
//Route::get('/pesquisar/{cell}', 'AlunoController@pesquisar');
//
//Route::get('/sms/{idAluno}', 'AlunoController@sms');


Route::get('/home', function (){
    return redirect()->route('admin.home');
})->middleware('check.gmail');

Route::get('/teste', function () {
    return view('testes.feito');
});
Route::get('/expired', function () {
    return view('errors.expired');
});


Route::get('/suporte', function () {
    return view('layouts.suporte');
});

//Route::get('/data', 'TestController@index');
//Route :: get ( ' /teste ' , function() {
//    phpinfo();
//});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function (){

    Auth::routes();

    Route::group(['middleware' => ['can:access-admin', 'check.gmail']], function (){



        Route::get('/home', 'Home2Controller@index')->name('home');
        Route::post('/home/data', 'Home2Controller@index3');

        Route::get('/delete/{idAluno}', 'HomeController@delete')->name('delete');
//        Route::get('/show/{idAluno}', 'AlunoController@show')->name('show');
//        Route::get('/sms/{idAluno}', 'AlunoController@sms')->name('sms');
        Route::get('/gerarusers/', 'StandardController@gerarUser')->name('gerarusers');

        //resumo caixa
        Route::get('/resumocaixa/{idven}', 'ResumoCaixaController@index2')->name('retornaresumo');
        Route::post('/resumocaixa/', 'ResumoCaixaController@indexGo')->name('retornaresumo');
        Route::get('/resumocaixa/aposta_premiada/{idven}/{idbase}/{idreven}/{datini}/{datfim}',
            'ResumoCaixaController@retornaApostaPremios')->name('apostapremiada');

        //movimentos de caixa
        Route::get('/movimentoscaixa/{idven}', 'MovimentosCaixaController@index2')->name('movimentocaixa');
        Route::post('/movimentoscaixa/{idven}', 'MovimentosCaixaController@indexGo')->name('movimentocaixa');
        Route::get('/movimentoscaixa2/', 'MovimentosCaixaController@addCaixa')->name('addcaixa');
        Route::post('/movimentoscaixa2/', 'MovimentosCaixaController@addCaixaGo')->name('addcaixa');
//
//        Route::post('/movimentoscaixa2/', function()
//        {
//            return 'Success! ajax in laravel 5';
//        });

        //rotas de testes da aplicação
        Route::get('/resumocaixa2/', 'ResumoCaixaController@retornaResumoCaixa')->name('caixa');
        Route::post('/resumocaixa2/', 'ResumoCaixaController@retornaResumoCaixa')->name('caixa');

        Route::get('/resumorevendedor/', 'ResumoCaixaController@retornaRevendedor')->name('retornarevendedor');
        Route::get('/test/', 'TestController@test')->name('test');
        Route::get('/adduserweb/', 'StandardController@addUserWeb')->name('adduser');


        //transmissoes de apostas
        Route::get('/apostas/{idven}', 'ApostasController@index2')->name('retornaresumo');
        Route::post('/apostas/', 'ApostasController@indexGo')->name('retornaresumo');
        Route::get('/apostas/view/{idven}', 'ApostasController@viewPule')->name('view_pule');
        Route::post('/apostas/view/{idven}', 'ApostasController@viewPuleGo')->name('view_pule');
        Route::get('/apostas/cancel/{idven}', 'ApostasController@cancelPule')->name('cancel_pule');
        Route::post('/apostas/cancel/{idven}', 'ApostasController@cancelPuleGo')->name('cancel_pule');
        Route::post('/apostas/cancel/pule/{idven}', 'ApostasController@cancelAposta')->name('cancel_pule');
        Route::get('/apostas/view/{pule}/{idven}',
            'ApostasController@retornaPule')->name('apostapremiada');

        //Apostas Premiadas
        Route::get('/apostaspremiadas/{idven}', 'ApostasPremiadaController@index2')->name('apostapremiada');
        Route::post('/apostaspremiadas/', 'ApostasPremiadaController@indexGo')->name('apostapremiadaGo');
        Route::post('/apostaspremiadas/paybet/', 'ApostasPremiadaController@payBet')->name('addcaixa');

        //RESULTADO DE SORTEIO

        Route::get('/resultadosorteio/{ideven}', 'ResultadoSorteioController@index2')->name('resultadosorteio');
        Route::post('/resultadosorteio/{ideven}', 'ResultadoSorteioController@indexGo')->name('resultadosorteioGo');


        //Manager Usuários
        Route::get('/manager/desktop/', 'StandardController@returnUsuarioDesktop')->name('manager-user-desktop');
        Route::get('/manager/web/', 'StandardController@returnUsuarioWeb')->name('manager-user-web');
        Route::get('/manager/web/create/{id}', 'StandardController@createUsuarioWeb')->name('create-user-web');
        Route::post('/manager/web/create/{id}', 'StandardController@createUsuarioWeb')->name('create-user-web');
        Route::post('/manager/web/update/{id}', 'StandardController@updateUsuarioWeb')->name('update-user-web');
        Route::get('/manager/web/insert/', 'StandardController@insertUsuarioWeb')->name('insert-user-web');
        Route::post('/manager/web/insert/', 'StandardController@insertUsuarioWeb')->name('insert-user-web');
//        Route::post('/manager/web/insert2/', 'StandardController@WebGo');

        Route::get('/manager/web-go/', 'StandardController@webinsert');
        Route::post('/manager/web-go/', 'StandardController@webinsertGo');



        //Senha do Dia
        Route::get('/senhadodia/{idven}', 'SenhaDiaController@index2')->name('senhadia');

        //Descarga Envidas
        Route::get('/descargasenviadas/{idven}', 'DescargasEnviadasController@index2')->name('descargaenviadas');
        Route::post('/descargasenviadas/{idven}', 'DescargasEnviadasController@indexGo')->name('descargaenviadas');
        Route::get('/descargasenviadas/view/{idven}/{idreven}/{idter}/{idapo}/{numpule}/{seqpalp}', 'DescargasEnviadasController@returnInfoDescEnv')->name('descargaenviadas');
        Route::get('/descargasenviadas/infoaposta/{numpule}/{seqpalp}', 'DescargasEnviadasController@returnInfoAposta')->name('infoaposta');
        Route::get('/descargasenviadas/infoapostadescarregadas/{numpule}/{seqpalp}/{seqdes}', 'DescargasEnviadasController@returnApostaDescarregadas')->name('infoapostadescarregadas');


        //Cadastro de usuário web

        Route::get('/acesso/desktop/', 'AcessoWebController@indexDesktop')->name('index.desktop');
        Route::get('/acesso/web/', 'AcessoWebController@indexWeb')->name('index.web');
        Route::get('/acesso/web/create/{id}', 'AcessoWebController@create')->name('create.get');
        Route::post('/acesso/web/create/data/{id}', 'AcessoWebController@createGo')->name('create.post');
        Route::post('/acesso/web/update/{id}', 'AcessoWebController@update')->name('update.post');


        //REVENDEDOR
        Route::get('/revendedor/create/{idven}', 'RevendedorController@index2')->name('revendedor');
        Route::get('/revendedor/create/{idven}/add', 'RevendedorController@createRevendedor')->name('revendedor-create');
        Route::get('/revendedor/update/{ideven}/{idreven}', 'RevendedorController@edit')->name('revendedor.edit');
        Route::post('/revendedor/update/{ideven}/{idreven}', 'RevendedorController@update')->name('revendedor.update');
        Route::post('/revendedor/create/{idven}/add', 'RevendedorController@createRevendedorGo')->name('revendedor.create');
        Route::get('/revendedor/limite/{idven}', 'RevendedorController@limite')->name('limite-credito');
        Route::get('/revendedor/base/{idbase}', 'RevendedorController@retornaBase')->name('retorna-base');
        Route::get('/revendedor/vendedor/{idbase}/{idven}', 'RevendedorController@retornaVend')->name('retorna-vend');

    });


});

