<div class="container">
	<div class="bemfrio">
		<img class="esquerda" src="https://www.benfrio.com/wp-content/uploads/2015/01/logota-e1421757958294.png" height="30" />
		<h2 class="esquerda"> Relatório </h2>
		<span> {{ date('d/m/Y H:m') }}</span>
	</div>

	<div class="cliente">
		<p><strong>Código: </strong>{{ $cliente->CODIGO_CLI }}</p>
		<p><strong>Cliente: </strong>{{ $cliente->NOME_CLI }}</p>
		<p><strong>Cidade: </strong>{{ $cliente->CIDADE_CLI }} - {{ $cliente->ESTADO_CLI }}</p>		
	</div>


</div>