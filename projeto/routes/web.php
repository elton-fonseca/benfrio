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

//Rotas de login e logoff

Route::prefix('login')->group(function () {
    Route::get('/', ['as' => 'logar', 'uses' => 'LoginController@mostrarIndex']);
    Route::post('/logar', ['as' => 'logarPost', 'uses' => 'LoginController@logarUsuario']);
});

Route::middleware(['my_auth'])->group(function () {
    //Rota para a página inicial
    Route::view('/','common.index')->name('index');


    //Grupo de NFE
    Route::prefix('nfe')->group(function () {
        Route::get('/', 'NfeController@mostrarIndex');
        Route::post('/buscar', 'NfeController@mostrarBusca');
        Route::get('/baixarxml/{nota}/{ano}/{mes}', 'NfeController@baixarXml');
        Route::get('/baixarpdf/{nota}/{ano}/{mes}', 'NfeController@baixarPdf');
    });

    //Posição vazia
    Route::get('/posicaovazia', ['as' => 'posicaovazia', 'uses' => 'CameraController@mostrarIndex']);



    Route::get('login/logoff', 'LoginController@logoffUsuario');

    //Rotas de estoque
    Route::prefix('estoque')->group(function () {
        Route::get('/', ['as' => 'estoqueListar', 'uses' => 'EstoqueController@posicaoEstoque']);

        //Buscar por nome de produto
        Route::post('/buscar', 'EstoqueController@mostrarBusca');

        //Gerar pdf
        Route::get('/pdf/{busca?}/{campo?}', 'EstoqueController@posicaoPdf');

        //Gerar xls
        Route::get('/xls/{busca?}/{campo?}', 'EstoqueController@posicaoXls');

        //Gerar txt
        Route::get('/txt/{busca?}/{campo?}', 'EstoqueController@posicaoTxt');


    });

    //Rotas de saida
    Route::prefix('saida')->group(function () {
        //Lista as saidas
        Route::get('/', ['as' => 'saidaListar', 'uses' => 'SaidaController@listarSaidas']);

        //Exibe view de criação de saida
        Route::view('/criar', 'saida.criar')->name('saidaCriar');

        //Criar o pedido de saida
        Route::post('/criarpost', ['as' => 'saidaCriarPost', 'uses' => 'SaidaController@criarPost']);

        //Editar o pedido de saida
        //Route::post('/editarpost/{saida}', ['as' => 'saidaEditarPost', 'uses' => 'SaidaController@editarPost'));

        //exibe view de inserção de pallets
        Route::get('/exibepallets/{saida}', ['as' => 'saidaExibePallets', 'uses' => 'SaidaController@exibePallets']);

        //exibe view de busca de inserção de pallets
        Route::post('/exibepalletsbusca/{saida}', ['as' => 'saidaExibePalletsBusca', 'uses' => 'SaidaController@exibePalletsBuscar']);

    //finalizar saida
        Route::get('/finalizasaida/{saida}', ['as' => 'saidaFinaliza', 'uses' => 'SaidaController@finalizaSaida']);

        //enviar email saida
        Route::get('/finalizaemail/{saida}', ['as' => 'saidaEmail', 'uses' => 'SaidaController@emailSaida']);
                    

        //visualizar saida
        Route::get('/visualizarsaida/{saida}', ['as' => 'saidaVisualiza', 'uses' => 'SaidaController@visualizarSaida']);


        //exibe view de inserção de pallets
        Route::get('/finalizasaida/{saida}', ['as' => 'saidaFinaliza', 'uses' => 'SaidaController@finalizaSaida']);

    //exibe view de inserção de pallets
        Route::get('/finalizasaidapdf/{saida}', ['as' => 'saidaFinalizaPdf', 'uses' => 'SaidaController@finalizaSaidaPdf']);

            //Apaga uma saida e todos os itens
        Route::get('/deletasaida/{saida}', ['as' => 'saidaDeleta', 'uses' => 'SaidaController@deletaSaida']);

        //Exibe página de edição
        Route::get('/relatorio-saidas-pendentes-xls', ['as' => 'relatorioSaidasPendentes', 'uses' => 'SaidaController@saidaPendenteRelatorioXls']);		
        
    });

    //Rotas de Item de saida
    Route::prefix('itemsaida')->group(function () {
        //Realiza a adição de pallet na saida
        Route::get('/addpallet/{saida}/{pallet}/{posicao}/{quantidade}', ['as' => 'saidaAddPallets', 'uses' => 'ItemSaidaController@addPallet']);
        Route::get('/deletapallet/{saida}/{pallet}/{pagina}', ['as' => 'saidaDeletaPallets', 'uses' => 'ItemSaidaController@deletaPallet']);
        
        //Retorna o status atual do saida
        Route::get('/status/{saida}', ['as' => 'saidaStatus', 'uses' => 'ItemSaidaController@statusItens']);
    });

});

