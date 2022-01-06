
		<table >
			<thead>
			  <tr>
			    <th>N Pallet</th>
					<th>Endereço</th>
					<th>Codigo</th>
			    <th>Produto</th>
			    <th>Volume</th>
			    <th>Entrada</th>
					<th>Vencto</th>
					<th>Lote cliente</th>
					<th>Status</th>
			    <th>Observação</th>
				</tr>
			</thead>
			<tbody>  
			<?php $numPallet = removeSerieDoPallet($pallets[0]->numero_pal); $cont = 0; 
						$totalPallets=0; $totalVolume=0; 
			?>
			  @foreach ($pallets as $pallet)
				<?php 

				$vencto = $pallet->df_ent;  
				for ($i=0; $i<3; $i++) {
					if ($vencto < date('Y-m-d') )
						$vencto = date('Y-m-d', strtotime("+15 days",strtotime($vencto)));
				}

				$empenhado = $pallet->ev_pal > 0;
			?>
			<?php 
					if ($numPallet != removeSerieDoPallet($pallet->numero_pal) && $cont > 0) :
						$numPallet = removeSerieDoPallet($pallet->numero_pal);    
			?>
			<tr>
					<td>total: {{ $totalPallets }}</td>
					<td></td>
					<td></td>
			    <td></td>
			    <td>{{ formataNumero($totalVolume) }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
			    <td></td>
			  </tr>	
				<?php 
					$totalPallets=0; $totalVolume=0; $totalPesol=0; $totalPesob=0;
					endif; $cont++; 
				?>			  
			  <tr>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ formataPallet($pallet->numero_pal) }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $pallet->camara_pal }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $pallet->codigo_pro }}</td>
			    <td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $pallet->descri_pro }}</td>
			    <td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ formataNumero($pallet->saldo_pal) }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ mysqlToBr($pallet->dta_ent) }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ mysqlToBr($vencto) }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $pallet->REFE_EN1 }}</td>
					<td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $empenhado ? formataNumero($pallet->ev_pal).'-empenhado' : 'Disponível' }}</td>
			    <td style="background-color: {{ $empenhado ? '#d6bebe' : ''}}">{{ $pallet->obs1_pal }}</td>
			  </tr>	
						
				<?php $totalPallets++; $totalVolume += $pallet->saldo_pal; ?>
			  @endforeach
			</tbody>  
		</table>
	</div>

