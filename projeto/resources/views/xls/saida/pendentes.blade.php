
		<table >
			<thead>
			  <tr>
			    <th>Saida</th>
				<th>Observacao</th>
				<th>Lote Cliente</th>
			    <th>N Pallet</th>
			    <th>Produto</th>
			    <th>Volume</th>
			  </tr>
			</thead>
			<tbody>  
		
			  @foreach ($saidas as $saida)
			
			<tr>
					<td>{{ $saida->NUMERO_SAI }}</td>
					<td>{{ $saida->OBS_SAI }}</td>
					<td>{{ $saida->REFE_EN1 }}</td>
			    	<td>{{ $saida->PALLET_SA1 }}</td>
			    	<td>{{ $saida->DESCRI_PRO }}</td>
					<td>{{ formataNumero($saida->QTD_SA1) }}</td>
					
			</tr>	
						
			  @endforeach
			</tbody>  
		</table>
	</div>
