var urlBase = window.location.origin;



function alteraMaiusculo(){
	var valor = document.getElementById("placa");
	var novoTexto = valor.value.toUpperCase();
	valor.value = novoTexto;
}




function confirmaExclusao( saida ) {
	urlSaida = urlBase + "/saida/deletasaida/" + saida;
	if ( window.confirm( "Confirma a exclusão?" ) ) window.location.href=urlSaida;
}	

/* Adiciona pallet a saida */
function addPallet(saida, pallet){
	posicao = $('#select_'+ pallet ).find('option').filter(':selected').val();

	url = urlBase + '/itemsaida/addpallet/' + saida + '/' + pallet + '/' + posicao;

	$('#td_add_'+pallet).html('Carregando');

	 $.ajax({url:url,success:function(result){
	 	//alert('teste' + result);
	 	if(result == "sucesso")
	 	{
	 		$('#tr_'+pallet).css('background-color', '#2ECC40');
	 		$('#td_add_'+pallet).html('Inserido');
	 		$('#td_posicao_'+pallet).html(posicao);

	 		url_status = urlBase + '/itemsaida/status/' + saida;

	 		$.ajax({url:url_status,success:function(result){
	 			$('#status-saida').html(result);
	 		}});


	 	}
	 	else 
	 	{
	 		//Só mostra a mensagem em caso de erro
	    	alert(result);
		}
	  }});



	
}