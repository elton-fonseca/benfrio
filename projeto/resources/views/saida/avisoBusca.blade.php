
@extends('common.base')

@section('body')
    <div class="container-saida">
        {{ Form::open(array(
            'url' => "saida/exibepalletsbusca/$saida",
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-inline '
            )) }}
            
                <div class="form-group">
                    <label for="busca">Buscar: </label>
                    <input type="text" name="busca" class="buscar-input input-block-level form-control" placeholder="parte do nome" />
                </div>
                
                <input type="submit" value="Buscar" class="btn btn-large btn-primary" />

        {{ Form::close() }}
        
    </div>  


	<div class="container-table">
		<h3 class="centro">Procure pelo nome do produto ou<br/> clique em buscar com campo vazio para exibir todos</h3>
	</div>

	<div class="rodapeStatus rodape">
		<div class="status-saida" id="status-saida">
			<span><strong>Nº pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</span>
	        <span><strong>Volume: </strong>{{ isset($totalItens->volume) ? $totalItens->volume : 0 }}</span><br/>
	        <span><strong>Peso liq.: </strong>{{ isset($totalItens->t_liq) ? $totalItens->t_liq : 0 }}</span>
	        <span><strong>Peso Bru. Apro.: </strong>{{ isset($totalItens->t_liq) ? $totalItens->t_liq + ($totalItens->qtd_pallets*100) : 0 }}</span>
		</div>
		<div class="btn-direita"><a href='{{ URL::to("saida/finalizasaida/{$saida}")  }}' class="btn btn-default">Terminar</a>
	</div>

@stop

