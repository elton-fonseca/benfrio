<?php

namespace App\Repositories;

use App\Models\ItemSaidaTemp;

class ItemSaidaTempRepository
{


    //Cria uma saída a partir dos dados do formulário
    public function addItem($saida, $pallet, $posicao, $quantidade)
    {
        $ItemSaida = new ItemSaidaTemp;
        $ItemSaida->NUMERO_SA1 = $saida;
        $ItemSaida->PALLET_SA1 = $pallet->NUMERO_PAL;
        $ItemSaida->QTD_SA1 = $quantidade; //$pallet->SALDO_PAL;
        $ItemSaida->PESOLIQ_SA1 = ($pallet->PL_PAL / $pallet->QTD_PAL) * $quantidade; //$pallet->PESOL_PAL
        $ItemSaida->PESO_SA1 = ($pallet->PB_PAL / $pallet->QTD_PAL) * $quantidade; //$pallet->PESOB_PAL;
        $ItemSaida->POSICAO_SA1 = $posicao;
        
        return $ItemSaida->save();
    }

    //remove Pallet da saida
    public function deletaItem($saida, $pallet)
    {
        //Recebe os pallet do repositorio de entrada
        return \DB::table('cadsa1_temp')
                    ->where('NUMERO_SA1', $saida)
                    ->where('PALLET_SA1', $pallet->NUMERO_PAL)
                    ->delete();
    }

    //Retorna todos os itens de uma saida
    public function getBySaida($saida)
    {
        return \DB::table('cadsa1_temp')
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadsa1_temp.PALLET_SA1, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->join('cadpal', 'cadsa1_temp.PALLET_SA1', '=', 'cadpal.NUMERO_PAL')
                    ->where('NUMERO_SA1', $saida)
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->get();
    }

    //Retorna todos os itens de uma saida
    public function getLimpoBySaida($saida)
    {
        return \DB::table('cadsa1_temp')
                    ->where('NUMERO_SA1', $saida)
                    ->get();
    }

    //Retorna todos os itens de uma saida
    public function getTotais($saida)
    {
        return \DB::table('cadsa1_temp')
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

    public function getByPallet($pallet)
    {
        return \DB::table('cadsa1_temp')
                    ->where('PALLET_SA1', $pallet)
                    ->first();
    }

    public function getPalletNaSaida($pallet, $saida)
    {
        return \DB::table('cadsa1_temp')
                    ->where('PALLET_SA1', $pallet)
                    ->where('NUMERO_SA1', $saida)
                    ->first();
    }
}
