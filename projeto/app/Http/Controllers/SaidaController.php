<?php namespace App\Http\Controllers;

use App\Repositories\SaidaRepository;
use App\Repositories\SaidaTempRepository;
use App\Repositories\ItemSaidaRepository;
use App\Repositories\ItemSaidaTempRepository;
use App\Repositories\EntradaRepository;
use App\Repositories\UsuarioRepository;

use App\Validators\Saida;
use App\helpers\Gerais;
use App\Http\Requests\SaidaRequest;
use Illuminate\Http\Request;

class SaidaController extends Controller
{
    private $saida;
    private $entrada;

    public function __construct()
    {
        $this->saida = new SaidaRepository();
        $this->saidaTemp = new SaidaTempRepository();
        $this->itemSaida = new ItemSaidaRepository();
        $this->itemSaidaTemp = new ItemSaidaTempRepository();
        $this->entrada = new EntradaRepository();
        $this->usuario = new UsuarioRepository();
    }

    //Exibe a posição de estoque
    public function listarSaidas()
    {
        //Recebe os registros do repositorio de saida
        $saidas = $this->saida->listarSaidas();

        return \View::make('saida.listar', array('saidas' => $saidas));
    }

    //Realiza a criação de saida
    public function criarPost(SaidaRequest $request)
    {
        $saidaId = $this->saidaTemp->criarSaida($request->all());
        
        if ($saidaId) {
            return \Redirect::to("saida/exibepallets/{$saidaId}");
        }
        
        return \Redirect::route('saidaCriar')
                                    ->with('mensagem', 'Erro ao criar Saída');
    }


    //Realiza a edição de saida
    public function editarPost($saida)
    {
        //Guarda os dados em uma sessão
        \Input::flash();

        //Instancia o validador de Saídas
        $validador = new Saida();

        //recebe os dados do Post
        $dados = \Input::all();

        //Tenta validar os dados
        if ($validador->passes($dados)) {
            //Cria a saida
            if ($this->saida->editarSaida($saida, $dados)) {
                \Input::flush();

                //O método gerar chave
                return \Redirect::to("saida/editarsaida/{$saida}")
                    ->with('mensagem', 'Gravado com sucesso');
            } else {
                return \Redirect::to("saida/editarsaida/{$saida}")
                      ->with('mensagem', 'Erro ao editar Saída');
            }
        }
 
        //Se der erro na validação envia para o login novamente
        return \Redirect::to("saida/editarsaida/{$saida}")
         ->withInput()
         ->withErrors($validador->getErrors());
    }


    //Exibe lista de pallets para adição
    public function exibePallets($saida)
    {
        //Recebe os pallets do repositorio de entrada
        $dados['pallets'] = $this->entrada->posicaoEstoque();

        //Envia o número da saida para a view
        $dados['saida'] = $saida;
        
        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaidaTemp->getTotais($saida);

        $dados['itensExistentes'] = $this->itemSaidaTemp->getBySaida($saida);

        return \View::make('saida.exibirPallets', $dados);
    }

    //Exibe lista de pallets para adição
    public function exibePalletsBuscar($saida, Request $request)
    {
        //Recebe os pallets do repositorio de entrada
        $dados['pallets'] = $this->entrada->posicaoEstoqueBusca($request->only(['busca', 'campo']));

        //Envia o número da saida para a view
        $dados['saida'] = $saida;
        
        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaidaTemp->getTotais($saida);

        $dados['itensExistentes'] = $this->itemSaidaTemp->getBySaida($saida);

        return \View::make('saida.exibirPallets', $dados);
    }

    //Exibe página de finalização do pedido
    public function editarSaida($saida)
    {
        
        //Recebe os saidas do repositorio de saidas
        $dados['saida'] = $this->saida->getSaida($saida);

        //Recebe os itens da saida
        $dados['itens'] = $this->itemSaida->getBySaida($saida);

        //print_r($dados['itens']);

        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaida->getTotais($saida);
        

        return \View::make('saida.editar', $dados);
    }

    //Exibe página de finalização do pedido
    public function finalizaSaida($saida)
    {
        //Recebe os saidas do repositorio de saidas
        $dados['saida'] = $this->saidaTemp->getSaida($saida);

        //Recebe os itens da saida
        $dados['itens'] = $this->itemSaidaTemp->getBySaida($saida);

        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaidaTemp->getTotais($saida);

        return \View::make('saida.finaliza', $dados);
    }

    //Exibe página de finalização do pedido
    public function emailSaida($saida)
    {
        try {
            \DB::beginTransaction();
            
            //Recebe os saidas do repositorio de saidas
            $saidaTemp= $this->saidaTemp->getSaida($saida);
            $novasaida = $this->saida->criarSaida($saidaTemp);

            //Recebe os itens da saida
            $itensTemp = $this->itemSaidaTemp->getLimpoBySaida($saidaTemp->NUMERO_SAI);
            $itensNovo = $this->itemSaida->addItens($itensTemp, $novasaida->NUMERO_SAI);

            $dados['totalItens'] = $this->itemSaida->getTotais($novasaida->NUMERO_SAI);
            $dados['saida'] = $novasaida;
            $dados['itens'] = $this->itemSaida->getBySaida($novasaida->NUMERO_SAI);
            
            $usuario = $this->usuario->getCliente();

            //Envia email
            \Mail::send('saida.email', $dados, function ($message) use ($usuario, $dados) {
                global $novasaida;
                $message->to('pedido@benfrio.com', 'Pedido')
                ->subject('Ped. saida ' . " Cliente(" . ucwords(strtolower($usuario->NOME_CLI)) . ") Pla(". $dados["saida"]->PLACA_SAI . ") N(" . $dados["saida"]->NUMERO_SAI . ")");
            });

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            
            return redirect()->route("saidaFinaliza", $saida)
                    ->with('mensagem', "Erro ao criar pedido! (".$e->getMessage().")")
                    ->withInput();
        }

        return \Redirect::to("saida")->with('mensagem', "Pedido Criado com sucesso");
    }


    //Exibe página de finalização do pedido
    public function visualizarSaida($saida)
    {
        //Recebe os saidas do repositorio de saidas
        $dados['saida'] = $this->saida->getSaida($saida);

        //Recebe os itens da saida
        $dados['itens'] = $this->itemSaida->getBySaida($saida);

        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaida->getTotais($saida);

        return \View::make('saida.visualizar', $dados);
    }

    //Remove saidas
    public function deletaSaida($saida)
    {

        //Recebe os itens da saida
        $itensSaida = $this->itemSaida->getBySaida($saida);

        //Desempenha os itens de entrada
        foreach ($itensSaida as $itemSaida) {
            $this->entrada->desempenhaPalletNum($itemSaida->PALLET_SA1);
        }

        //Remove todos os itens da saida
        $this->itemSaida->deletaAllItens($saida);

        //Remove a saida
        $r_saida = $this->saida->deletaSaida1($saida);


        if ($r_saida) {
            return \Redirect::route('saidaListar')
                      ->with('mensagem', 'Excluido com sucesso');
        } else {
            return \Redirect::route('saidaListar')
                      ->with('mensagem', 'Erro ao Excluir');
        }
    }


    //Gera o PDF com os detalhes da saida
    public function finalizaSaidaPdf($saida)
    {
        //Recebe os saidas do repositorio de saidas
        $dados['saida'] = $this->saida->getSaida($saida);

        //Recebe os itens da saida
        $dados['itens'] = $this->itemSaida->getBySaida($saida);

        //Pega os totais dos itens de saida
        $dados['totalItens'] = $this->itemSaida->getTotais($saida);

        //Busca os dados do cliente para exibir no cabeçalho
        $dados['cliente'] = $this->usuario->getCliente();
        

        $html = \View::make('pdf.saida.finalizar', $dados)->render();

        return gerarPDF($html);
    }

    //Gerar XLS
    public function saidaPendenteRelatorioXls()
    {
        $saidas = $this->saida->listarSaidasPendentes();

        $html = \View::make(
            'xls.saida.pendentes',
            [
            'saidas' => $saidas
            ]
        )->render();

        return gerarXls($html);
    }
}
