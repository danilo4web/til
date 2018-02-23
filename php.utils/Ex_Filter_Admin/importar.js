	jQuery( document ).ready(function() {
		jQuery('#ImportarFiltroForm').submit(function() { return false; });
		
		jQuery('#busca_importar').click(function() { busca_importar(); });
		jQuery('#limpar_busca').click(function() { limpar_busca(); });
		
		jQuery("#modelo_carregando").clone().appendTo("#listagem");
		jQuery('#listagem #modelo_carregando').css('display', 'block');
		
		jQuery('#listagem').load('/cbnew/Importar/listar/');
	});
	
	function limpar_busca(){
		jQuery('#ImportarFiltroForm').find('input').val('');
		jQuery('#ImportarFiltroForm').find('select').val('');
		
		busca_importar();
	}
	
	function busca_importar() {
		jQuery.ajax({
			method: "POST",
			url: "/cbnew/Importar/listar/",
			data: jQuery('#ImportarFiltroForm').serialize(),
			dataType: "html",
			beforeSend: function() {
				jQuery('#listagem #modelo_carregando').css('display', 'block');
			},		
			success: function(listagem) {
				jQuery('#listagem').html(listagem);
			}
		});
	}	
