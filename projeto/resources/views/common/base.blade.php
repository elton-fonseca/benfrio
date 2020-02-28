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

        <!--[if !IE]><!-->
            <script type="text/javascript" src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <!--<![endif]-->


        <title>Sistema Benfrio</title>
    </head>
    <body>
        @include('common.cabecalho')
        
        @if(\Session::get('mensagem'))
            <div class="alert alert-danger">{{ \Session::get('mensagem') }}</div>
        @endif
	    	

		@yield('body')

    		
    	@section('js')
    		<script type="text/javascript" src="{{ URL::asset('assets/js/vendor/jquery-2.1.0.min.js') }}"></script>
    		<script type="text/javascript" src="{{ URL::asset('assets/js/vendor/bootstrap.min.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/js/funcoes.js') }}"></script>

    	@show

    </body>
 </html>
