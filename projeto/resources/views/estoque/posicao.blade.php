@extends('common.base')

@section('body')
    <div class="container-saida" style="width: 500px">
        {{ Form::open(array(
            'url' => 'estoque/buscar',
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-inline '
            )) }}
            
                <div class="form-group">
                    <label for="busca">Buscar: </label>
										<input type="text" name="busca" class="buscar-input input-block-level form-control" placeholder="Busca" required value="{{ request('busca') }}" />
										
										<select class="buscar-input input-block-level form-control" name="campo">
											<option value="descri_pro" {{ request('campo') == "descri_pro" ? "selected" : "" }}>Descrição Produto</option>
											<option value="codigo_pro" {{ request('campo') == "codigo_pro" ? "selected" : "" }}>Código Produto</option>
											<option value="numero_pal" {{ request('campo') == "numero_pal" ? "selected" : "" }}>N.° Pallet</option>
											<option value="nfe_ent" {{ request('campo') == "nfe_ent" ? "selected" : "" }}>NF-e Entrada</option>
											<option value="REFE_EN1" {{ request('campo') == "REFE_EN1" ? "selected" : "" }}>Lote Cliente</option>
											<option value="obs1_pal" {{ request('campo') == "obs1_pal" ? "selected" : "" }}>Observação</option>
										</select>

                </div>
                
                <input type="submit" value="Buscar" class="btn btn-large btn-primary" />

        {{ Form::close() }}
        
    </div>   

	<div class="container-table">
		<table class="rwd-table">
			<thead>
			  <tr>
			    <th>N.° Pallet</th>
					<th>NF-e Entrada</th>
					<th>Lote Cliente</th>
			    <th>Produto</th>
			    <th>Saldo</th>
			    <th>Peso</th>
			    <th>Data Ent.</th>
					<th>Vcto</th>
					<th>Status</th>
			    <th>Obs</th>
			  </tr>
			</thead>
			<tbody>  

			  @foreach ($pallets as $pallet)

			  <?php 
			  	  $vencto = $pallet->df_ent;  
			     
			      for ($i=0; $i<3; $i++) {
			      	if ($vencto < date('Y-m-d') )
				     	$vencto = date('Y-m-d', strtotime("+15 days",strtotime($vencto)));
						}
					
						$empenhado = $pallet->ev_pal > 0;
				?>    			  
			  
			  <tr style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">
			    <td data-th="N Pallet">{{ formataPallet($pallet->numero_pal) }}</td>
					<td data-th="NFe Ent." class="teste">{{ $pallet->nfe_ent }}</td>
					<td data-th="Lote Cliente">{{ $pallet->REFE_EN1 }}</td>
			    <td data-th="Produto">({{ $pallet->codigo_pro }}) {{ $pallet->descri_pro }}</td>
			    <td data-th="Saldo">{{ formataNumero($pallet->saldo_pal) }}</td>
			    <td data-th="Peso">{{ formataNumero($pallet->pesob_pal) }}</td>
			    <td data-th="Data Entrada.">{{ mysqlToBr($pallet->dta_ent) }}</td>
					<td data-th="vencto">{{ mysqlToBr($vencto) }}</td>
					<td data-th="vencto">{{ $empenhado ? formataNumero($pallet->ev_pal) . '-empenhado' : 'Disponível' }}</td>
			    <td data-th="Obs">{{ empty($pallet->obs1_pal) ? '-' : $pallet->obs1_pal }}</td>
			  </tr>	
			  		
			  @endforeach
			</tbody>  
		</table>
	</div>

	<div class="espaco"></div>

	<div class="rodapeStatus rodape">
		<div class="status-saida" id="status-saida">
			<span><strong>Nº pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</span>
	        <span><strong>Volume: </strong>{{ isset($totalItens->volume) ? (int) $totalItens->volume : 0 }}</span><br/>
	        <span><strong>Peso liq.: </strong>{{ isset($totalItens->t_liq) ? $totalItens->t_liq : 0 }}</span>
	        <span><strong>Peso Bru. Apro.: </strong>{{ isset($totalItens->t_liq) ? $totalItens->t_liq + ($totalItens->qtd_pallets*100) : 0 }}</span>
		</div>
		<div class="btn-direita">
			<strong style="titulo">Posição de estoque </strong> 
			<?php $buscar = $busca['busca'] ?? '' ?>
			<?php $campo = $busca['campo'] ?? '' ?>

			<a href='{{  URL::to("estoque/txt/$buscar/$campo")  }}' class="btn btn-default">TXT</a>
			<a href='{{  URL::to("estoque/xls/$buscar/$campo")  }}' class="btn btn-default">XLS</a>
			<a href='{{  URL::to("estoque/pdf/$buscar/$campo")  }}' class="btn btn-default">PDF</a>
		</div>
	</div>

@stop
