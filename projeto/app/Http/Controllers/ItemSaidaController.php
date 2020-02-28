<?php namespace App\Http\Controllers;

use App\Repositories\ItemSaidaRepository;
use App\Repositories\EntradaRepository;

class ItemSaidaController extends Controller
{
    private $saida;
    private $entrada;

    public function __construct()
    {
        $this->itemSaida = new ItemSaidaRepository();
        $this->entrada = new EntradaRepository();
    }

    //Adicionar Pallet a saida
    public function addPallet($saida, $pallet, $posicao)
    {
        //Recebe os pallet do repositorio de entrada
        $pallet = $this->entrada->retornaPallet($pallet);

        if ($this->itemSaida->addItem($saida, $pallet, $posicao) && $this->entrada->empenhaPallet($pallet)) {
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

        if ($this->itemSaida->deletaItem($saida, $pallet) && $this->entrada->desempenhaPallet($pallet)) {
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
        $dados = $this->itemSaida->getTotais($saida);

        $pesoBruto = $dados->t_liq + ($dados->qtd_pallets * 100);

        echo "<span><strong>Nº pallets: </strong>$dados->qtd_pallets</span> ";
        echo "<span><strong>Volume: </strong>$dados->volume</span><br/>";
        echo "<span><strong>Peso liq.: </strong>$dados->t_liq</span> ";
        echo "<span><strong>Peso Bru. Apro.: </strong>$pesoBruto</span>";
    }
}
