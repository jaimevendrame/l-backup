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
        Route::get('/gerarusers/', 'HomeController@gerarUser')->name('gerarusers');
        Route::get('/resumocaixa/', 'ResumoCaixaController@index')->name('retornaresumo');
        Route::post('/resumocaixa/', 'ResumoCaixaController@indexGo')->name('retornaresumoGo');


        Route::get('/resumocaixa2/', 'ResumoCaixaController@retornaResumoCaixa')->name('caixa');
        Route::post('/resumocaixa2/', 'ResumoCaixaController@retornaResumoCaixa')->name('caixa');

        Route::get('/resumorevendedor/', 'ResumoCaixaController@retornaRevendedor')->name('retornarevendedor');
        Route::get('/test/', 'TestController@test')->name('test');



    });


});

