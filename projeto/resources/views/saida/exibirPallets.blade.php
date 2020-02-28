
@extends('common.base')

@section('body')
	<div class="container-table">
		<div class="alert alert-danger">
			<p>É necessário clicar no botão <strong>terminar</strong> na próxima tela para o pedido ser efetivado</p>
		</div>
	</div>
    <div class="container-saida" style="width: 500px">
        {{ Form::open(array(
            'url' => "saida/exibepalletsbusca/{$saida}",
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-inline '
            )) }}
            
                <div class="form-group">
                    <label for="busca">Buscar: </label>
										<input type="text" name="busca" class="buscar-input input-block-level form-control" placeholder="Busca" value="{{ request('busca') }}" />

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
					<th>N Pallet</th>
					<th>Lote Cliente</th>
			    <th>Produto</th>
			    <th>Saldo</th>
			    <th>Data Ent.</th>
			    <th>Vencto</th>
					<th>Status</th>
					<th>Obs</th>
			    <th>Posição</th>
			    <th>Adicionar</th>
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

			  
			  <tr style="background-color: {{ $empenhado ? '#d6bebe' : ''}}" id="tr_{{ $pallet->numero_pal }}">
					<td data-th="N Pallet">{{ formataPallet($pallet->numero_pal) }}</td>
					<td data-th="Lote Clientet">{{ $pallet->REFE_EN1 }}</td>
			    <td data-th="Produto">({{ $pallet->codigo_pro }}) {{ $pallet->descri_pro }}</td>
			    <td data-th="Saldo">{{ formataNumero($pallet->saldo_pal) }}</td>
			    <td data-th="Data Ent.">{{ mysqlToBr($pallet->dta_ent) }}</td>
					<td data-th="Vencto">{{ mysqlToBr($vencto) }}</td>
					<td data-th="Status">{{ $empenhado ? formataNumero($pallet->ev_pal).'-empenhado' : 'disponível' }}</td>
			    <td data-th="Obs">{{ empty($pallet->obs1_pal) ? '-' : $pallet->obs1_pal }}</td>
			    <td id="td_posicao_{{ $pallet->numero_pal }}" data-th="posição">
						@if (!$empenhado)
			    	<select id="select_{{ $pallet->numero_pal }}">
			    	  <option value="indiferente">Indiferen.</option>
					  <option value="traseira">Traseira</option>
					  <option value="meio">Meio</option>
					  <option value="frente">Frente</option>
					</select>
					@endif
					</td>	
					@if (!$empenhado)
						<td id="td_add_{{ $pallet->numero_pal }}" data-th="Adicionar"><button onClick="addPallet('{{ $saida }}', '{{ $pallet->numero_pal }}')">Adiciona</button></td>
					@else
						<td></td>	
					@endif	
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
		<div class="btn-direita"><a href='{{ URL::to("saida/finalizasaida/{$saida}")  }}' class="btn btn-default">Visualizar Pedido</a>
	</div>

@stop

