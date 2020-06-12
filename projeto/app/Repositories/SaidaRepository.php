<?php

namespace App\Repositories;

use App\Models\Saida;
use App\helpers\Gerais;

class SaidaRepository
{
    //Lista todas as saidas do periodo fixo no código
    public function listarSaidas()
    {
        $dados = \DB::table('cadsai')
            ->select('NUMERO_SAI', 'PLACA_SAI', 'EMISSA_SAI', 'DATAS_SAI', 'CHEGADA_SAI', 'OBS_SAI', 'NFS_SAI', 'WEB_SAI')
            ->where('CODCLI_SAI', \Session::get('cod_cliente'))
            ->whereBetween('EMISSA_SAI', array( date('Y-m-d', strtotime("-15 days")), date('Y-m-d') ))
            ->orderBy('NUMERO_SAI', 'desc')
            ->get();

        return $dados;
    }

    //Cria uma saída a partir dos dados do formulário
    public function criarSaida($saida)
    {
        $novaSaida = new \stdClass;
        $novaSaida->NUMERO_SAI = $this->addZero($this->ultimoID()+1);
        $novaSaida->PLACA_SAI = $saida->PLACA_SAI;
        $novaSaida->DATAS_SAI = $saida->DATAS_SAI;
        $novaSaida->CHEGADA_SAI = $saida->CHEGADA_SAI;
        $novaSaida->OBS_SAI = $saida->OBS_SAI;

        //automáticos
        $novaSaida->CODCLI_SAI = \Session::get('cod_cliente');
        $novaSaida->EMISSA_SAI = date('Y-m-d');
        $novaSaida->HORA_SAI = date('Hi');
        $novaSaida->WEB_SAI = '1';

        \DB::table('cadsai')->insert((array) $novaSaida);

        return $novaSaida;
    }


    //Editar saida
    public function editarSaida($numero_saida, $saida)
    {
        $msaida = array();
        $msaida['PLACA_SAI'] = ($saida['placa'] != '') ;
        $msaida['DATAS_SAI'] = implode("-", array_reverse(explode("/", $saida['datas'])));
        $msaida['CHEGADA_SAI'] = ($saida['chegada']) ? formataHoraBanco($saida['chegada']) : 0;
        $msaida['OBS_SAI'] = $saida['obs'];

        return \DB::table('cadsai')
            ->where('NUMERO_SAI', $numero_saida)
            ->update($msaida);
    }


    //Gera a chave para uma nova saida
    public function ultimoID()
    {
        $resultado = \DB::table('cadsai')
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
        $resultado = \DB::table('cadsai')
                                ->select('NUMERO_SAI', 'PLACA_SAI', 'EMISSA_SAI', 'DATAS_SAI', 'CHEGADA_SAI', 'OBS_SAI')
                                ->where('NUMERO_SAI', $saida)
                                ->first();

        return $resultado;
    }

    //remove saida
    public function deletaSaida1($saida)
    {
        $codcli = (string) \Session::get('cod_cliente');

        //Grava o log quando exclui
        \DB::table('cadlog')->insert(
            array(
                'NUMERO_LOG' => $saida,
                'GUIA_LOG' => "S",
                'DATA_LOG' => date('Y-m-d'),
                'HORA_LOG' => date('h:m'),
                'USUARIO_LOG' => $codcli
                )
        );

        //Recebe os pallet do repositorio de entrada
        $teste = \DB::table('cadsai')
                    ->where('NUMERO_SAI', $saida)
                    ->delete();
        //var_dump($teste);

        return $teste;
    }
}
