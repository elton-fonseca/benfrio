
@extends('pdf.common.base')

@section('body')
	<div class="saida-detalhes">
         <h2>Pedido de saida núm. {{ $saida->NUMERO_SAI }}</h2>
        <p class="saida-detalhes-item"><strong>Numero Saída: </strong>{{ $saida->NUMERO_SAI }}</p>
        <p><strong>Data Criação: </strong>{{ mysqlToBr($saida->EMISSA_SAI) }}</p>
        <p class="saida-detalhes-item"><strong>Data previsão de retirada: </strong>{{ mysqlToBr($saida->DATAS_SAI) }}</p>
        <p><strong>Placa Caminhão: </strong>{{ isset($saida->PLACA_SAI) ? $saida->PLACA_SAI : ' Não cadastrada' }}</p>
        <p class="saida-detalhes-item"><strong>Hora previsão de retirada: </strong>{{  (strlen($saida->CHEGADA_SAI) >= 4) ? formataHora($saida->CHEGADA_SAI) : 0  }}</p>
        <p><strong>Total de pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</p>
        <p class="saida-detalhes-item"><strong>Total de Volume: </strong>{{ isset($totalItens->volume) ? $totalItens->volume : 0 }}</p>
        <p><strong>Peso liquido total: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq) : 0 }}</p>
        <p class="saida-detalhes-item"><strong>Peso Bruto total: </strong>{{ isset($totalItens->t_bru) ? formataNumero($totalItens->t_bru) : 0 }}</p>
        <p><strong>Observação: </strong>{{ $saida->OBS_SAI }}</p>
    </div>

    <h2>Itens do pedido</h2>
	<table class="rwd-table">
		<thead>
		  <tr>
				<th>N Pallet</th>
				<th>Lote Cliente</th>
		    <th>Descrição</th>
		    <th>Volume</th>
		    <th>Peso B.</th>
		    <th>Posição</th>
		    <th>OBS</th>
		  </tr>
		</thead>
		<tbody>  

		  @foreach ($itens as $item)  
		  <tr>
				<td data-th="N Pallet">{{ isset($item->PALLET_SA1) ? formataPallet($item->PALLET_SA1) : 0 }}</td>
				<td data-th="Lote Cliente">{{ isset($item->REFE_EN1) ? $item->REFE_EN1 : 0 }}</td>
		    <td data-th="Descrição">({{ $item->CODIGO_PRO }}) {{ isset($item->DESCRI_PRO) ? $item->DESCRI_PRO : 0 }}</td>
		    <td data-th="Volume">{{ isset($item->QTD_SA1) ? $item->QTD_SA1 : 0 }}</td>
		    <td data-th="Peso B.">{{ isset($item->PESO_SA1) ? formataNumero($item->PESO_SA1+100): 0 }}</td>
			<td data-th="Posição">{{ posicao($item->POSICAO_SA1) }}</td>
		  	<td data-th="OBS">{{ isset($item->OBS1_PAL) ? $item->OBS1_PAL : "-" }}</td>
		  </tr>		
		  @endforeach
		</tbody>  
	</table>

    </div>


@stop
