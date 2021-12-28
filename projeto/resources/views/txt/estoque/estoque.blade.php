{{ date('d/m/Y') }}     BENFRIO ARMAZENS GERAIS LTDA {{"\r\n"}}
{{ date('H:m') }}          demostrativo de saldos nas câmaras {{"\r\n"}}
               Cliente: {{ $cliente->NOME_CLI }}   ({{ $cliente->CODIGO_CLI }}) {{"\r\n"}}
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}
pallet       Codigo  Descricao                                            Volume   Peso Liq.  Peso Bruto Entrada    Vencto     St NFE    Observacao {{"\r\n"}}
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}
<?php $numPallet = removeSerieDoPallet($pallets[0]->numero_pal); $cont = 0; 
$totalPallets=0; $totalVolume=0; $totalPesol=0; $totalPesob=0;?>
@foreach ($pallets as $pallet)
<?php 
  $vencto = $pallet->df_ent;  
  for ($i=0; $i<3; $i++) {
  	if ($vencto < date('Y-m-d') )
     	$vencto = date('Y-m-d', strtotime("+15 days",strtotime($vencto)));
  }
?>
<?php 
    if ($numPallet != removeSerieDoPallet($pallet->numero_pal) && $cont > 0) :
      $numPallet = removeSerieDoPallet($pallet->numero_pal);    
?>
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}
Total --> Pallets: {{ $totalPallets }}<?php if($totalPallets <= 9) echo " "; ?>                                                      {{ formataNumero($totalVolume) }}<?php for($i=strlen(formataNumero($totalVolume)); $i<10; $i++) echo " "; ?>{{ formataNumero($totalPesol) }}<?php for($i=strlen(formataNumero($totalPesol)); $i<=9; $i++) echo " "; ?>{{formataNumero($totalPesob)}}
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}
<?php 
$totalPallets=0; $totalVolume=0; $totalPesol=0; $totalPesob=0;
endif; $cont++; ?>
{{ formataPallet($pallet->numero_pal) }} {{ $pallet->codigo_pro }}<?php for($i=strlen($pallet->codigo_pro); $i<8; $i++) echo " "; ?> {{ $pallet->descri_pro }}     <?php for($i=strlen($pallet->descri_pro); $i<48; $i++) echo " "; ?> {{ formataNumero($pallet->saldo_pal - $pallet->ev_pal) }}<?php for($i=strlen(formataNumero($pallet->saldo_pal - $pallet->ev_pal)); $i<9; $i++) echo " "; ?>{{ formataNumero($pallet->pesol_pal) }}<?php for($i=strlen(formataNumero($pallet->pesol_pal)); $i<10; $i++) echo " "; ?>{{ formataNumero($pallet->pesob_pal) }}<?php for($i=strlen(formataNumero($pallet->pesob_pal)); $i<=10; $i++) echo " "; ?>{{ mysqlToBr($pallet->dta_ent) }} {{ mysqlToBr($vencto) }} {{ $pallet->nfe_ent }}<?php for($i=strlen($pallet->codigo_pro); $i<6; $i++) echo " "; ?>   {{ $pallet->obs1_pal }}{{"\r\n"}}
<?php 
  $totalPallets++;
  $totalVolume += $pallet->saldo_pal;
  $totalPesol  += $pallet->pesol_pal;
  $totalPesob  += $pallet->pesob_pal;
?>
@endforeach
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}
Total de Pallets: {{ isset($totalItens->qtd_pallets) ? formataNumero($totalItens->qtd_pallets) : 0 }}   Saldo Total: {{ isset($totalItens->volume) ? formataNumero($totalItens->volume) : 0 }}   peso Liq. Total: {{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq) : 0 }}   Peso Bruto Total: {{ isset($totalItens->t_liq) ? formataNumero($totalItens->t_liq + ($totalItens->qtd_pallets*100)) : 0 }} {{"\r\n"}}
----------------------------------------------------------------------------------------------------------------------------------------------------------------- {{"\r\n"}}