<?php

namespace App\Repositories;

class UsuarioRepository
{
    public function buscarUsuario($dados)
    {
        $resultado = \DB::table('cadcli')
            ->select('NOME_CLI', 'CODIGO_CLI')
            ->where('CODIGO_CLI', $dados['usuario'])
            ->where('sen_cli', $dados['senha'])
            ->first();
    
        if (!$resultado) {
            return false;
        } else {
            \Session::put('cliente', $resultado->NOME_CLI);
            \Session::put('cod_cliente', $resultado->CODIGO_CLI);

            return true;
        }
    }

    public function getCliente()
    {
        return \DB::table('cadcli')
                    ->where('CODIGO_CLI', \Session::get('cod_cliente'))
                    ->first();
    }
}
