<?php

namespace App\Repositories;

use App\Models\SaidaTemp;
use App\helpers\Gerais;

class SaidatempRepository
{


    //Cria uma saída a partir dos dados do formulário
    public function criarSaida($saida)
    {

        $msaida = new SaidaTemp;
        $msaida->NUMERO_SAI = $this->addZero($this->ultimoID()+1);
        $msaida->PLACA_SAI = $saida['placa'];
        $msaida->DATAS_SAI = implode("-", array_reverse(explode("/", $saida['datas'])));
        $msaida->CHEGADA_SAI = ($saida['chegada']) ? formataHoraBanco($saida['chegada']) : 0;
        $msaida->OBS_SAI = $saida['obs'];

        //automáticos
        $msaida->CODCLI_SAI = \Session::get('cod_cliente');
        $msaida->EMISSA_SAI = date('Y-m-d');
        $msaida->HORA_SAI = date('Hi');
        $msaida->WEB_SAI = '1';

        $msaida->save();

        return $msaida->NUMERO_SAI;
    }

    //Gera a chave para uma nova saida
    public function ultimoID()
    {
        $resultado = \DB::table('cadsai_temp')
                                ->select('NUMERO_SAI')
                                ->orderBy(\DB::raw('CONVERT(NUMERO_SAI, SIGNED)'), 'desc')
                                ->take(1)
                                ->first();

        return $resultado->NUMERO_SAI;
    }

        //Gera a chave para uma nova saida
        public function addZero($saida)
        {
            $saida = (string) $saida;
    
            if (strlen($saida) == 4) {
                $zeros = '00';
            }
            if (strlen($saida) == 5) {
                $zeros = '0';
            }
            if (strlen($saida) == 6) {
                $zeros = '';
            }
    
            return $zeros . $saida;
        }


    //Pega um saida única a partir do codigo
    public function getSaida($saida)
    {
        $resultado = \DB::table('cadsai_temp')
                                ->select('NUMERO_SAI', 'PLACA_SAI', 'EMISSA_SAI', 'DATAS_SAI', 'CHEGADA_SAI', 'OBS_SAI')
                                ->where('NUMERO_SAI', $saida)
                                ->first();

        return $resultado;
    }


}
