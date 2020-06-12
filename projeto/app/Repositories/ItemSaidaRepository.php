<?php

namespace App\Repositories;

use App\Models\ItemSaida;

class ItemSaidaRepository
{
    //Cria uma saída a partir dos dados do formulário
    public function addItens($itens, $codSaida)
    {
        $entrada = new EntradaRepository;

        $itensArray = [];
        foreach ($itens as $item) {
            $itemTemp = (array) $item;
            $itemTemp['NUMERO_SA1'] = $codSaida;
            $itensArray[] = $itemTemp;

            $pallet = $entrada->retornaPallet($item->PALLET_SA1);

            if ($pallet->EV_PAL == $pallet->SALDO_PAL) {
                throw new \Exception("Pallet {$pallet->NUMERO_PAL} já está empenhado", 1);
            }

            $entrada->empenhaPallet($pallet);
        }

        return \DB::table('cadsa1')->insert($itensArray);

    }

    //Cria uma saída a partir dos dados do formulário
    // public function addItem($saida, $pallet, $posicao)
    // {
    //     $ItemSaida = new ItemSaida;
    //     $ItemSaida->NUMERO_SA1 = $saida;
    //     $ItemSaida->PALLET_SA1 = $pallet->NUMERO_PAL;
    //     $ItemSaida->QTD_SA1 = $pallet->SALDO_PAL;
    //     $ItemSaida->PESOLIQ_SA1 = $pallet->PESOL_PAL;
    //     $ItemSaida->PESO_SA1 = $pallet->PESOB_PAL;
    //     $ItemSaida->POSICAO_SA1 = $posicao;
        
    //     return $ItemSaida->save();
    // }

    //remove Pallet da saida
    // public function deletaItem($saida, $pallet)
    // {
    //     //Recebe os pallet do repositorio de entrada
    //     return \DB::table('cadsa1')
    //                 ->where('NUMERO_SA1', $saida)
    //                 ->where('PALLET_SA1', $pallet->NUMERO_PAL)
    //                 ->delete();
    // }

    //Retorna todos os itens de uma saida
    public function getBySaida($saida)
    {
        return \DB::table('cadsa1')
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadsa1.PALLET_SA1, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->join('cadpal', 'cadsa1.PALLET_SA1', '=', 'cadpal.NUMERO_PAL')
                    ->where('NUMERO_SA1', $saida)
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->get();
    }
    

    //Retorna todos os itens de uma saida
    public function getTotais($saida)
    {
        return \DB::table('cadsa1')
                    ->select(
                        \DB::raw('count(*) as qtd_pallets'),
                        \DB::raw('sum(QTD_SA1) AS volume'),
                        \DB::raw('sum(PESOLIQ_SA1) AS t_liq'),
                        \DB::raw('sum(PESO_SA1) AS t_bru')
                    )
                    ->whereRaw("NUMERO_SA1 = $saida")
                    ->groupBy('NUMERO_SA1')
                    ->first();
    }

    //remove todos os itens de saida
    public function deletaAllItens($saida)
    {
        //Recebe os pallet do repositorio de entrada
        return \DB::table('cadsa1')
                    ->where('NUMERO_SA1', $saida)
                    ->delete();
    }
}
