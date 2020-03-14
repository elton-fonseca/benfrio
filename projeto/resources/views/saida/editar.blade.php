
@extends('common.base')

@section('body')
    <div class="container">
        @foreach($errors->all('<li>:message</li>') as $message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endforeach


      <div class="caixa-login">
        <h2>Editar Pedido de saída N {{$saida->NUMERO_SAI}}</h2>


        {{ Form::open(array(
            'url' => "saida/editarpost/{$saida->NUMERO_SAI}",
            'method' => 'POST',
            'accept-charset' => 'UTF-8',
            'class' => 'form-signin saida_form'
            )) }}
        <p><strong>Total de pallets: </strong>{{ isset($totalItens->qtd_pallets) ? $totalItens->qtd_pallets : 0 }}</p>
        <p><strong>Total de Volume: </strong>{{ isset($totalItens->volume) ? (int) $totalItens->volume : 0 }}</p>
        <p><strong>Peso liquido total: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq) : 0 }}</p>
        <p><strong>Peso Bruto Aproximado: </strong>{{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq + ($totalItens->qtd_pallets*100) ) : 0 }}</p>
            
            	
               <div class="form-group">
                <label for="placa">Placa Caminhão:</label> Atual {{$saida->PLACA_SAI}} <br/>
                <input type="text" name="placa" class="input-block-level" placeholder="Placa" onKeyPress="return !(event.keyCode==13);" value="{{ $saida->PLACA_SAI }}" />
               
               </div>
               <div class="form-group">
                <label for="datas">Data retirada:</label> Atual - {{ mysqlToBr($saida->DATAS_SAI) }} <br/>
                <input type="text" name="datas" class="input-block-level" placeholder="Revisão retirada" onKeyPress="return !(event.keyCode==13);" value="{{ mysqlToBr($saida->DATAS_SAI) }}" />
               </div>                   
               <div class="form-group">
                <label for="chegada">Hora retirada:</label> Atual - {{ (strlen($saida->CHEGADA_SAI) >= 4) ? formataHora($saida->CHEGADA_SAI) : 0 }}<br/>
                <input type="text" name="chegada" class="input-block-level" placeholder="Revisão retirada" onKeyPress="return !(event.keyCode==13);" value="{{ (strlen($saida->CHEGADA_SAI) >= 4) ? formataHora($saida->CHEGADA_SAI) : 0 }}" />
               </div>                      
               <div class="form-group">
                <label for="obs">Observação ou Nome Motorista:</label> Atual - {{ $saida->OBS_SAI }}<br/>
                <textarea class="form-control" name='obs' rows="3">{{ $saida->OBS_SAI }}</textarea>

               </div>  

                <input type="submit" value="salvar alterações" class="btn btn-large btn-primary" />

        {{ Form::close() }}





      </div>

    <h2>Itens do pedido</h2>
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
			    <th>Excluir</th>
			  </tr>
			</thead>
			<tbody>  

			  @foreach ($itens as $item)  
			  <tr>
          <td data-th="N Pallet">{{ isset($item->PALLET_SA1) ? $item->PALLET_SA1 : 0 }}</td>
          <td data-th="Lote Cliente">{{ isset($item->REFE_EN1) ? $item->REFE_EN1 : 0 }}</td>
          <td data-th="Produto">({{ $item->CODIGO_PRO }}) {{ isset($item->DESCRI_PRO) ? $item->DESCRI_PRO : 0 }}</td>
			    <td data-th="Volume">{{ isset($item->QTD_SA1) ? (int) $item->QTD_SA1 : 0 }}</td>
			    <td data-th="Peso L.">{{ isset($item->PESOLIQ_SA1) ? formataNumero($item->PESOLIQ_SA1) : 0 }}</td>
			    <td data-th="Peso B.">{{ isset($item->PESO_SA1) ? formataNumero($item->PESO_SA1) : 0 }}</td>
          <td data-th="Posição">{{ posicao($item->POSICAO_SA1) }}</td>
			    <td data-th="Remover"><a href='{{URL::to("itemsaida/deletapallet/{$saida->NUMERO_SAI}/{$item->PALLET_SA1}/e")}}'>Remover</span></td>
			  </tr>		
			  @endforeach
			</tbody>  
		</table>

		<div class="espaco"></div>

    </div>

	<div class="rodape">
	<div class="btn-direita"><a href='{{ URL::to("saida")  }}' class="btn btn-default">Terminar</a></div>
		<div class="btn-direita"><a href='{{ URL::to("saida/exibepallets/{$saida->NUMERO_SAI}")  }}' class="btn btn-default">Inserir Mais pallets</a></div>
	</div>

@stop

