<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
        @section('css')
            <link rel="stylesheet" type="text/css" media="all" href="{{ URL::asset('assets/css/vendor/bootstrap.min.css') }}" />
        	<link rel="stylesheet" type="text/css" media="all" href="{{ URL::asset('assets/css/style-pdf-estoque.css') }}" />
        @show
        <title>Sistema BenFrio</title>
    </head>
    <body>
		@include('pdf.estoque.cabecalho')
	    	

		@yield('body')

    		
 

    </body>
 </html>