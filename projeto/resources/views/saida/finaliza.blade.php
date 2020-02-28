
@extends('common.base')

@section('body')
    <div class="container">


<!-- Modal -->
<div class="modal show" id="myModal" role="dialog">
  <div class="modal-dialog">
  
	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="$('.modal').removeClass('show').addClass('fade');">&times;</button>
		<h4 class="modal-title">AVISO</h4>
	  </div>
	  <div class="modal-body">
		<p>É necessário clicar no botão <strong>Terminar</strong> para efetivar o pedido</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('.modal').removeClass('show').addClass('fade');">Fechar Mensagem</button>
	  </div>
	</div>
	
  </div>
</div>


	<div class="alert alert-danger">
		<p>É necessário clicar no botão <strong>terminar</strong> para o pedido ser efetivado</p>
	</div>

      <div class="caixa-login">
        <h2>Finalizar Pedido - Confirme os valores</h2>
        <p><strong>Numero Saída: </strong>{{ $saida->NUMERO_SAI }}</p>
        <p><strong>Data Criação: </strong>{{ mysqlToBr($saida->EMISSA_SAI) }}</p>
        <p><strong>Data previsão de retirada: </strong>{{ mysqlToBr($saida->DATAS_SAI) }}</p>
        <p><strong>Hora previsão de retirada: </strong>{{ (strlen($saida->CHEGADA_SAI) >= 4) ? formataHora($saida->CHEGADA_SAI) : 0 }}</p>
        <p><strong>Placa Caminhão: </strong>{{ isset($saida->PLACA_SAI) ? $saida->PLACA_SAI : ' Não cadastrada' }}</p>
        <p><strong>Total de pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</p>
        <p><strong>Total de Volume: </strong>{{ isset($totalItens->volume) ? (int) $totalItens->volume : 0 }}</p>
        <p><strong>Peso liquido total: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq) : 0 }}</p>
        <p><strong>Peso Bruto Aproximado: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq + ($totalItens->qtd_pallets*100)) : 0 }}</p>
        <p><strong>Observação: </strong>{{ $saida->OBS_SAI }}</p>
      </div>

		<table class="rwd-table">
			<thead>
			  <tr>
					<th>N Pallet</th>
					<th>Lote Cliente</th>
			    <th>Produto</th>
			    <th>Volume</th>
			    <th>Peso L.</th>
			    <th>Peso B.</th>
			    <th>Posição</th>
			    <th>OBS</th>
			    <th>Excluir</th>
			  </tr>
			</thead>
			<tbody>  

			@foreach ($itens as $item)  
			  <tr>
			    <td data-th="N Pallet">{{ isset($item->PALLET_SA1) ? formataPallet($item->PALLET_SA1) : 0 }}</td>
					<td data-th="Lote Cliente">{{ isset($item->REFE_EN1) ? $item->REFE_EN1 : 0 }}</td>
          <td data-th="Produto">({{ $item->CODIGO_PRO }}) {{ isset($item->DESCRI_PRO) ? $item->DESCRI_PRO : 0 }}</td>
			    <td data-th="Volume">{{ isset($item->QTD_SA1) ? (int) $item->QTD_SA1 : 0 }}</td>
			    <td data-th="Peso L.">{{ isset($item->PESOLIQ_SA1) ? formataNumero($item->PESOLIQ_SA1) : 0 }}</td>
			    <td data-th="Peso B.">{{ isset($item->PESO_SA1) ? formataNumero($item->PESO_SA1) : 0 }}</td>
			    <td data-th="Posição">{{ $item->POSICAO_SA1 }}</td>
			    <td data-th="OBS">{{ isset($item->OBS1_PAL) ? $item->OBS1_PAL : "-" }}</td>
			    <td data-th="Remover"><a href='{{URL::to("itemsaida/deletapallet/{$saida->NUMERO_SAI}/{$item->PALLET_SA1}/f")}}'>Remover</span></td>
			  </tr>		
			@endforeach
			</tbody>  
		</table>

		<div class="espaco"></div>

    </div>

	<div class="rodape">
	<div class="btn-direita"><a href='{{ URL::to("saida/finalizaemail/{$saida->NUMERO_SAI}")  }}' class="btn btn-default">Terminar</a></div>
		<div class="btn-direita"><a href='{{ URL::to("saida/exibepallets/{$saida->NUMERO_SAI}")  }}' class="btn btn-default">Inserir Mais pallets</a></div>
	</div>

@stop

