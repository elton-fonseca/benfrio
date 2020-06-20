
@extends('common.base')

@section('body')
	<div class="container-table">
		<table class="rwd-table">
			<thead>
			  <tr>
			    <th>N.° Saída</th>
			    <th>Placa</th>
			    <th>Data Criação</th>
			    <th>Previsão Retirada</th>
			    <th>Observação</th>
			    <th>PDF</th>
				<th>Visualizar</th>
			    <th>Apagar</th>
			  </tr>
			</thead>
			<tbody>  

			 @foreach ($saidas as $saida)
				<tr>
						<td data-th="Num. Saída">{{       $saida->NUMERO_SAI }}</td>
						<td data-th="Placa">{{             $saida->PLACA_SAI }}</td>
						<td data-th="Data Criação">{{      mysqlToBr($saida->EMISSA_SAI) }}</td>
						<td data-th="Previsão Retirada">{{ mysqlToBr($saida->DATAS_SAI) }}</td>
						<td data-th="Observação">{{ 	   empty($saida->OBS_SAI) ? '-' : $saida->OBS_SAI }}</td>
						<td data-th="Gerar PDF"><a href='{{ URL::to("saida/finalizasaidapdf/{$saida->NUMERO_SAI}") }}' class="btn btn-default btn-sm">Gerar PDF</a></td>
						<td data-th="visualizar"><a href='{{ URL::to("saida/visualizarsaida/{$saida->NUMERO_SAI}")  }}' class="btn btn-success btn-sm">visualizar</a></td>
						@if($saida->WEB_SAI = '1')	
							@if($saida->NFS1_SAI)
								<td data-th="Apagar">Expedido</td>
							@elseif($saida->IMPRESSA_SAI == "1")
								<td data-th="Apagar">Em Separação</td>
							@else
								<td data-th="Apagar"><a href='#' onclick="confirmaExclusao('{{$saida->NUMERO_SAI }}')" class="btn btn-danger btn-sm">Deletar</a></td>
							@endif
						@else
							<td data-th="Apagar">Criado em outro sistema</td>
						@endif					    		
				</tr>	
			  @endforeach
			</tbody>  
		</table>

		<a class="btn btn-default" href="{{ route('relatorioSaidasPendentes') }}">Exportar Guias Pendentes para XLS</a>
	</div>

	<div class="espaco"></div>

	<div class="rodape">

		<div class="btn-direita"><a href="{{ URL::to('saida/criar')  }}" class="btn btn-default">Adicionar Novo</a>
	</div>
@stop

