<?php namespace App\Http\Controllers;

use App\Repositories\ItemSaidaRepository;
use App\Repositories\ItemSaidaTempRepository;
use App\Repositories\EntradaRepository;

class ItemSaidaController extends Controller
{
    private $saida;
    private $entrada;

    public function __construct()
    {
        $this->itemSaida = new ItemSaidaRepository();
        $this->itemSaidaTemp = new ItemSaidaTempRepository();
        $this->entrada = new EntradaRepository();
    }

    //Adicionar Pallet a saida
    public function addPallet($saida, $pallet, $posicao, $quantidade)
    {
        //Recebe os pallet do repositorio de entrada
        $palletItem = $this->entrada->retornaPallet($pallet);

        //pegar por saida e pallet
        if ($this->itemSaidaTemp->getPalletNaSaida($pallet, $saida)) {
            return 'Esse item já está adicionado a saída';
        }

        if ($quantidade > ($palletItem->SALDO_PAL - $palletItem->EV_PAL)) {
            return 'Quantidade maior que o saldo disponível';
        }

        if ($this->itemSaidaTemp->addItem($saida, $palletItem, $posicao, $quantidade)) {
            echo "sucesso";
        } else {
            echo "falha";
        }
    }

    //Remove Pallet da saida
    public function deletaPallet($saida, $pallet, $pagina)
    {
        //Recebe os pallet do repositorio de entrada
        $pallet = $this->entrada->retornaPallet($pallet);

        if ($this->itemSaidaTemp->deletaItem($saida, $pallet)) {
            if ($pagina == 'f') {
                return \Redirect::to("saida/finalizasaida/{$saida}")
                    ->with('mensagem', 'Excluído com sucesso');
            } elseif ($pagina == 'e') {
                return \Redirect::to("saida/editarsaida/{$saida}")
                    ->with('mensagem', 'Excluído com sucesso');
            }
        } else {
            echo "<script>alert('Erro ao excluir')</script>";
        }
    }

    public function statusItens($saida)
    {
        //Pega os totais dos itens de saida
        $dados = $this->itemSaidaTemp->getTotais($saida);

        $pesoBruto = $dados->t_liq + ($dados->qtd_pallets * 100);

        echo "<span><strong>Nº pallets: </strong>$dados->qtd_pallets</span> ";
        echo "<span><strong>Volume: </strong>$dados->volume</span><br/>";
        echo "<span><strong>Peso liq.: </strong>$dados->t_liq</span> ";
        echo "<span><strong>Peso Bru. Apro.: </strong>$pesoBruto</span>";
    }
}
