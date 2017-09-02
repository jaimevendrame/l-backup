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

    Route::group(['middleware' => 'can:access-admin'], function (){



        Route::get('/home', 'Home2Controller@index')->name('home');
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


        //transmissoes
        Route::get('/apostas/{idven}', 'ApostasController@index2')->name('retornaresumo');
        Route::post('/apostas/', 'ApostasController@indexGo')->name('retornaresumo');
        Route::get('/apostas/view/{idven}', 'ApostasController@viewPule')->name('view_pule');
        Route::post('/apostas/view/{idven}', 'ApostasController@viewPuleGo')->name('view_pule');
        Route::get('/apostas/view/{pule}/{idven}',
            'ApostasController@retornaPule')->name('apostapremiada');



    });


});

