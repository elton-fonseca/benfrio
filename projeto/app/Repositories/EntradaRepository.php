<?php

namespace App\Repositories;

use App\helpers\Gerais;

class EntradaRepository
{
    public function posicaoEstoque()
    {
        //echo 'teste';
        $dados = \DB::table('cadpal')
                    ->select('numero_pal', \DB::raw('saldo_pal-ev_pal as saldo'), 'pesob_pal', 'pesol_pal', 'obs1_pal', 'dta_ent', 'nfe_ent', 'descri_pro', 'df_ent', 'REFE_EN1', 'codigo_pro', 'ev_pal', 'saldo_pal', 'camara_pal')
                    ->join('cadent', 'cadent.numero_ent', '=', \DB::raw('left(cadpal.numero_pal, 6)'))
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadpal.numero_pal, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->where('CODCLI_ENT', \Session::get('cod_cliente'))
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->whereRaw('saldo_pal > 0')
                    ->where('ev_pal', '>=', 0)
                    ->orderBy(\DB::raw('CONVERT(numero_pal, SIGNED)'), 'asc')
                    ->get();

        return $dados;
    }

    //Busca por nome
    public function posicaoEstoqueBusca($parametros)
    {
        $busca = '%'. $parametros['busca'] . '%';

        //Remove pontos
        $busca = limpaPallet($busca);
       
        $dados = \DB::table('cadpal')
                    ->select('numero_pal', \DB::raw('saldo_pal-ev_pal as saldo'), 'pesob_pal', 'pesol_pal', 'obs1_pal', 'dta_ent', 'nfe_ent', 'descri_pro', 'df_ent', 'REFE_EN1', 'codigo_pro', 'ev_pal', 'camara_pal', 'saldo_pal')
                    ->join('cadent', 'cadent.numero_ent', '=', \DB::raw('left(cadpal.numero_pal, 6)'))
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadpal.numero_pal, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->where('CODCLI_ENT', \Session::get('cod_cliente'))
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->where($parametros["campo"], 'like', $busca)
                    ->whereRaw('saldo_pal > 0')
                    ->where('ev_pal', '>=', 0)
                    ->orderBy(\DB::raw('CONVERT(numero_pal, SIGNED)'), 'asc')
                    ->get();

        return $dados;
    }

    //Retona um pallet por numero
    public function retornaPallet($pallet)
    {
        return \DB::table('cadpal')
                    ->where('numero_pal', $pallet)
                    ->first();
    }

    //Realiza o emprenho do pallet
    public function empenhaPallet($pallet)
    {
        return \DB::table('cadpal')
                ->where('numero_pal', $pallet->NUMERO_PAL)
                ->update(array('EV_PAL' => $pallet->SALDO_PAL,
                               'EL_PAL' => $pallet->PESOL_PAL,
                               'EB_PAL' => $pallet->PESOB_PAL, ));
    }

    //Realiza o desemprenho do pallet
    public function desempenhaPallet($pallet)
    {

        //Realiza o emprenho
        return \DB::table('cadpal')
                ->where('numero_pal', $pallet->NUMERO_PAL)
                ->update(array('EV_PAL' => 0,
                               'EL_PAL' => 0,
                               'EB_PAL' => 0 ));
    }

    //Realiza o desemprenho do pallet por numero
    public function desempenhaPalletNum($numero_pal)
    {

        //Realiza o emprenho
        return \DB::table('cadpal')
                ->where('numero_pal', $numero_pal)
                ->update(array('EV_PAL' => 0,
                               'EL_PAL' => 0,
                               'EB_PAL' => 0 ));
    }




    //Retorna os totais de pallets
    public function getTotais()
    {
        $dados = \DB::table('cadpal')
                    ->select(
                        \DB::raw('count(*) as qtd_pallets'),
                        \DB::raw('sum(saldo_pal) as volume'),
                        \DB::raw('sum(pesob_pal) AS t_bru'),
                        \DB::raw('sum(PESOL_PAL) AS t_liq')
                    )
                    ->join('cadent', 'cadent.numero_ent', '=', \DB::raw('left(cadpal.numero_pal, 6)'))
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadpal.numero_pal, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->where('CODCLI_ENT', \Session::get('cod_cliente'))
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->whereRaw('saldo_pal > 0')
                    ->where('ev_pal', '>=', 0)
                    ->first();

        return $dados;
    }

    //retorna os totais de pallets com busca
    public function getTotaisBusca($parametros)
    {
        $busca = '%'. $parametros['busca'] . '%';

        //Remove pontos
        $busca = limpaPallet($busca);

        $dados = \DB::table('cadpal')
                    ->select(
                        \DB::raw('count(*) as qtd_pallets'),
                        \DB::raw('sum(saldo_pal) as volume'),
                        \DB::raw('sum(pesob_pal) AS t_bru'),
                        \DB::raw('sum(PESOL_PAL) AS t_liq')
                    )
                    ->join('cadent', 'cadent.numero_ent', '=', \DB::raw('left(cadpal.numero_pal, 6)'))
                    ->join('caden1', 'caden1.lote_en1', '=', \DB::raw('left(cadpal.numero_pal, 8)'))
                    ->join('cadpro', 'caden1.codpro_en1', '=', 'cadpro.codigo_pro')
                    ->where('CODCLI_ENT', \Session::get('cod_cliente'))
                    ->where('CODCLI_PRO', \Session::get('cod_cliente'))
                    ->where($parametros["campo"], 'like', $busca)
                    ->whereRaw('saldo_pal > 0')
                    ->where('ev_pal', '>=', 0)
                    ->first();

        return $dados;
    }
}
