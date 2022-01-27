
@extends('pdf.estoque.base')

@section('body')
	<div class="container-table">
		<table class="">
			<thead>
			  <tr>
			    <th>Pallet</th>
			    <th>Produto</th>
			    <th>Saldo</th>
			    <th>Entrada</th>
					<th>Vencto</th>
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
			<tr style="background-color: #fff; font-weight: bold;">
					<td><h6 style="font-weight: bold; font-size: 10px;">total: {{ $totalPallets }}</h6></td>
					<td></td>
			    <td><h6 style="font-weight: bold; font-size: 10px;">{{ formataNumero($totalVolume) }}</h6></td>
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
					<td style="width: 80px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ formataPallet($pallet->numero_pal) }}</td>
			    	<td style="width: 360px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ $pallet->descri_pro }}</td>
			    	<td style="width: 40px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ formataNumero($pallet->saldo_pal) }}</td>
					<td style="width: 60px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ mysqlToBr($pallet->dta_ent) }}</td>
					<td style="width: 60px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ mysqlToBr($vencto) }}</td>
			    	<td style="width: 160px; background-color: {{ $empenhado ? '#ababab' : '#FFF'}}">{{ $pallet->obs1_pal }}</td>
			  </tr>	
						
				<?php $totalPallets++; $totalVolume += $pallet->saldo_pal; ?>
			  @endforeach
			</tbody>  
		</table>

@stop
