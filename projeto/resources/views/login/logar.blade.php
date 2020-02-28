<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
        @section('css')
        	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/vendor/bootstrap.min.css') }}" />
        	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}" />
        @show
        <title>Sistema Benfrio</title>
    </head>
    <body>
	    	
        <div class="container">
        @if(\Session::get('mensagem'))
            <div class="alert alert-danger">{{ \Session::get('mensagem') }}</div>
        @endif

        @foreach($errors->all('<li>:message</li>') as $message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endforeach
            <div class="caixa-login">

            {{ Form::open(array(
                'url' => 'login/logar',
                'method' => 'POST',
                'accept-charset' => 'UTF-8',
                'class' => 'form-signin login_form'
                )) }}
                
              
                    <h2 class="form-signin-heading">Entre com usuário e senha</h2>
                    <div class="form-group" class="control-label">
                        <label for="usuario">Usuário: </label>
                        <input type="text" name="usuario" value="{{ old('usuario') }}" class="input-block-level form-control" placeholder="Usuário" required />
                    </div>
                    <div class="form-group" class="control-label">
                        <label for="senha">Senha: </label>
                        <input type="password" name="senha" class="input-block-level form-control" placeholder="Senha" required />
                    </div>

                    <input type="submit" value="Efetuar login" class="btn btn-large btn-primary" />

            {{ Form::close() }}
            </div>
        </div>          

    	@section('js')
    		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    		<script type="text/javascript" src="{{ URL::asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    	@show

    </body>
 </html>