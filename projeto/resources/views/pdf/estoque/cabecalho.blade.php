<div class="container">
	<div class="esquerda header-text" style="width: 100px;">
		<p>{{ date('d/m/Y') }}</p>
		<p>{{ date('H:m') }}</p>
		<p></p>
	</div>
	<div class="esquerda header-text" style="width: 400px;">
		
		<p style="margin-bottom: 1px"><strong>BENFRIO ARMAZENS GERAIS LTDA.</strong></p>
		<p style="margin-bottom: 1px">DEMONSTRATIVO DE SALDO</p>
		<p>CLIENTE:
		{{ $cliente->NOME_CLI }} ({{ $cliente->CODIGO_CLI }})</p>
	</div>
	<div class="direita" style="width: 200px;">
		<img class="direita" src="https://www.benfrio.com/wp-content/uploads/2015/01/logota-e1421757958294.png" height="30" />
	</div>
</div>