
@extends('common.base')

@section('body')


    <div class="container-saida">
        

        {{ Form::open(array(
            'url' => 'nfe/buscar',
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-inline '
            )) }}
            
                <div class="form-group">
                    <label for="busca">Buscar: </label>
                    <input type="text" name="busca" class="buscar-input input-block-level form-control" placeholder="Num. Nfe" required value="{{ request('busca') }}"/>
                </div>
                
                <input type="submit" value="Buscar" class="btn btn-large btn-primary" />

        {{ Form::close() }}
        
    </div>    

	<div class="container-table">
		<table class="rwd-table">
			<thead>
			  <tr>
			    <th>NF-e</th>
			    <th>Data</th>
			    <th>Placa</th>
			    <th>Mensagem</th>
			    <th>Baixar</th>
			  </tr>
			</thead>
			<tbody>  
			  @foreach ($NFEs as $nfe)
			  
			  <tr>
			  
			    <td data-th="NFE">{{ $nfe->NF_EXP }}</td>
			    <td data-th="Data">{{ date('d/m/Y', strtotime($nfe->EMISSA_EXP)) }}</td>
			    <td data-th="Placa">{{ (empty($nfe->PLACA_EXP)) ? '-' : $nfe->PLACA_EXP }}</td>
			    <td data-th="Mensagem">{{ (empty($nfe->MENS1_EXP)) ? '-' : $nfe->MENS1_EXP  }}</td>
			    <td data-th="Baixar">
					<?php 
							$ano = date('Y', strtotime($nfe->EMISSA_EXP)); 
							$mes = date('m', strtotime($nfe->EMISSA_EXP));
					?>
					@if (existeXml($nfe->NF_EXP, $ano, $mes))
						<a href='{{ URL::to("nfe/baixarxml/{$nfe->NF_EXP}/{$ano}/{$mes}")  }}' class="btn btn-danger btn-sm">XML</a>
					@endif
					@if (existePdf($nfe->NF_EXP, $ano, $mes))
						<a href='{{ URL::to("nfe/baixarpdf/{$nfe->NF_EXP}/{$ano}/{$mes}")  }}' class="btn btn-danger btn-sm">PDF</a>
					@endif

				</td>

			  </tr>	
			  		
			  @endforeach
			</tbody>  
		</table>
		<p class="danger">Arquivos mais antigos, procure pelo número</p>
	</div>

	<div class="espaco"></div>

	<div class="rodape">
		
		<div class="btn-direita">
			<strong style="titulo">Baixar NFE </strong> 
			
		</div>
	</div>

@stop

