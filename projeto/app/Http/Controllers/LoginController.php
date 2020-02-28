<?php

namespace App\Http\Controllers;

use App\Repositories\UsuarioRepository;
use App\Validators\Usuario;
use App\Http\Requests\UsuarioRequest;

class LoginController extends Controller
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new UsuarioRepository();
    }

    //Exibe a página de login
    public function mostrarIndex()
    {
        return \View::make('login.logar');
    }

    //Realiza o login
    public function logarUsuario(UsuarioRequest $request)
    {
        //Verifica se o usuário existe
        if ($this->usuario->buscarUsuario($request->all())) {
            return \Redirect::route('estoqueListar');
        } else {
            return \Redirect::route('logar')
                    ->with('mensagem', 'Usuário ou senha não errado');
        }
    }

    //Realizar Logoff
    public function logoffUsuario()
    {
        \Session::put('cliente', null);
        \Session::put('cod_cliente', null);

        return \Redirect::to('login')
              ->with('mensagem', 'Logoff realizado com sucesso');
    }
}
