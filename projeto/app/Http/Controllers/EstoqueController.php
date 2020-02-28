<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EntradaRepository;
use App\Repositories\UsuarioRepository;

class EstoqueController extends Controller
{
    private $entrada;

    public function __construct()
    {
        $this->entrada = new EntradaRepository();
        $this->usuario = new UsuarioRepository();
    }

    //Exibe a posição de estoque
    public function posicaoEstoque()
    {
        //Recebe os pallets do repositorio de entrada
        $pallets = $this->entrada->posicaoEstoque();

        //Pega os totais dos PALLETS
        $totalItens = $this->entrada->getTotais();
        

        return \View::make('estoque.posicao', [
                'pallets' => $pallets,
                'busca' => null,
                'totalItens' => $totalItens
        ]);
    }

    //Buscar Pallet por nome do produto
    public function mostrarBusca(Request $request)
    {
        $buscar = $request->only(['busca', 'campo']);

        //Busca os pallets a partir do parametro recebido via post
        $pallets = $this->entrada->posicaoEstoqueBusca($buscar);

        //Pega os totais dos PALLETS
        $totalItens = $this->entrada->getTotaisBusca($buscar);


        return \View::make('estoque.posicao', [
                    'pallets' => $pallets,
                    'busca' => $buscar,
                    'totalItens' => $totalItens
                ]);
    }


    //Gerar PDF
    public function posicaoPdf($busca=null, $campo=null)
    {
        if ($busca && $campo) {
            $pallets = $this->entrada->posicaoEstoqueBusca(['busca' => $busca, 'campo' => $campo]);
            $totalItens = $this->entrada->getTotaisBusca(['busca' => $busca, 'campo' => $campo]);
        } else {
            $pallets = $this->entrada->posicaoEstoque();
            $totalItens = $this->entrada->getTotais();
        }
        
        $cliente = $this->usuario->getCliente();

        $html = \View::make(
            'pdf.estoque.estoque',
            [
            'pallets' => $pallets,
            'cliente' => $cliente,
            'totalItens' => $totalItens
            ]
        )->render();

        return gerarPDF($html, 'paisagem');
    }

    //Gerar XLS
    public function posicaoXls($busca=null, $campo=null)
    {
        if ($busca && $campo) {
            $pallets = $this->entrada->posicaoEstoqueBusca(['busca' => $busca, 'campo' => $campo]);
        } else {
            $pallets = $this->entrada->posicaoEstoque();
        }

        $html = \View::make(
            'xls.estoque.estoque',
            [
            'pallets' => $pallets
            ]
        )->render();

        return gerarXls($html);
    }

    //Gerar txt
    public function posicaoTxt($busca=null, $campo=null)
    {
        if ($busca && $campo) {
            $pallets = $this->entrada->posicaoEstoqueBusca(['busca' => $busca, 'campo' => $campo]);
            $totalItens = $this->entrada->getTotaisBusca(['busca' => $busca, 'campo' => $campo]);
        } else {
            $pallets = $this->entrada->posicaoEstoque();
            $totalItens = $this->entrada->getTotais();
        }
        
        $cliente = $this->usuario->getCliente();

        $html = \View::make(
            'txt.estoque.estoque',
            [
            'pallets' => $pallets,
            'cliente' => $cliente,
            'totalItens' => $totalItens
            ]
        )->render();

        return gerarTxt($html);
    }
}
