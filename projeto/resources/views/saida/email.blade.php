<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <title>Pedido de saída</title>
    </head>
    <body>

  	  <div>
        <h2>Dados da Saída</h2>
        <p><strong>Numero Saída: </strong>{{ $saida->NUMERO_SAI }}</p>
        <p><strong>Data Criação: </strong>{{ mysqlToBr($saida->EMISSA_SAI) }}</p>
        <p><strong>Data previsão de retirada: </strong>{{ mysqlToBr($saida->DATAS_SAI) }}</p>
        <p><strong>Hora previsão de retirada: </strong>{{ (strlen($saida->CHEGADA_SAI) >= 4) ? formataHora($saida->CHEGADA_SAI) : 0 }}</p>
        <p><strong>Total de pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</p>
        <p><strong>Total de Volume: </strong>{{ isset($totalItens->volume) ? $totalItens->volume : 0 }}</p>
        <p><strong>Peso liquido total: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq) : 0 }}</p>
        <p><strong>Peso Bruto Aproximado: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq + ($totalItens->qtd_pallets*100)) : 0 }}</p>
        <p><strong>Observação: </strong>{{ $saida->OBS_SAI }}</p>
      </div>

      <div>
        <h2>Itens da Saída</h2>
		<table class="rwd-table">
			<thead>
			  <tr>
			    <th>N Pallet</th>
			    <th>Produto</th>
			    <th>Volume</th>
			    <th>Peso L.</th>
			    <th>Peso B.</th>
			    <th>Posição</th>
			    <th>Excluir</th>
			  </tr>
			</thead>
			<tbody>  

			  @foreach ($itens as $item)  
			  <tr>
			    <td data-th="N Pallet">{{ isset($item->PALLET_SA1) ? $item->PALLET_SA1 : 0 }}</td>
			    <td data-th="Produto">{{ isset($item->DESCRI_PRO) ? $item->DESCRI_PRO : 0 }}ASD</td>
			    <td data-th="Volume">{{ isset($item->QTD_SA1) ? (int) $item->QTD_SA1 : 0 }}</td>
			    <td data-th="Peso L.">{{ isset($item->PESOLIQ_SA1) ? formataNumero($item->PESOLIQ_SA1) : 0 }}</td>
			    <td data-th="Peso B.">{{ isset($item->PESO_SA1) ? formataNumero($item->PESO_SA1) : 0 }}</td>
				<td data-th="Posição">{{ posicao($item->POSICAO_SA1) }}</td>
			  </tr>		
			  @endforeach
			</tbody>  
		</table>

	  </div>

    </body>
 </html>
