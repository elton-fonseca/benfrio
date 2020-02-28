<?php

namespace App\Repositories;

class NfeRepository
{

    //Notas dos últimos 30 dias do cliente
    public function trazerNfe()
    {
        //echo 'teste';
        $dados = \DB::table('cadexp')
                    ->select('NF_EXP', 'EMISSA_EXP', 'PLACA_EXP', 'MENS1_EXP')
                    ->where('STATUS_EXP', '<>', 'c')
                    ->where('CODCLI_EXP', \Session::get('cod_cliente'))
                    ->whereBetween('EMISSA_EXP', array( date('Y-m-d', strtotime("-1400 days")), date('Y-m-d') ))
                    ->orderBy('EMISSA_EXP', 'desc')
                    ->limit(40)
                    ->get();

        return $dados;
    }

    //Notas dos últimos 30 dias do cliente
    public function trazerNfeBusca($nfe)
    {
        $nfe = '%'. $nfe['busca'] . '%';
        //echo 'teste';
        $dados = \DB::table('cadexp')
                    ->select('NF_EXP', 'EMISSA_EXP', 'PLACA_EXP', 'MENS1_EXP')
                    ->where('STATUS_EXP', '<>', 'c')
                    ->where('CODCLI_EXP', \Session::get('cod_cliente'))
                    ->where('NF_EXP', 'like', $nfe)
                    ->orderBy('EMISSA_EXP', 'desc')
                    ->get();

        return $dados;
    }
}
