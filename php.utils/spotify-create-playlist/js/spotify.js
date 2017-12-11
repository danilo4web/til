$(function() {
	$('#escolha-tema .tampinha').click(function() {
		$('#input_motivo').val($(this).data('motive'));
		$('input[name="name_motivo"]').val('');
		
		$('#escolha-tema .tampinha').removeClass('active');
		$(this).addClass('active');
	});
	
	$('input[name="name_motivo"]').change(function() {
		$('#input_motivo').val($(this).val());
	});
	
	$('input[name="name_motivo"]').keypress(function() {
		$('#escolha-tema .tampinha').removeClass('active');
	});
	
	$('#escolha-ritmo .tampinha').click(function() {
		if($(this).hasClass('active')) {
			$(this).removeClass('active');	
		} else {
			$(this).addClass('active');
		}		
	});
	
	$('#escolha-duracao .tampinha').click(function() {
		$('#escolha-duracao .tampinha').removeClass('active');
		
		$(this).addClass('active');
		$('input[name="duration"]').val($(this).data('time'));
	});	
	
	
	$('input[name="duration"]').change(function() {
		if($(this).val() > 12) {
			$(this).val(12);
			
			$('.typed-time').after('<label id="excedido_horario">Máxima permitido: 12 horas</label>').delay(3000).queue(function() {
			    $('#excedido_horario').fadeOut().remove();
			});
		}
		
		$('#escolha-duracao .tampinha').removeClass('active');
	})
});


function call_ritmo() {
	$('#escolha-tema').hide();
	$('#escolha-ritmo').fadeIn();
}

function call_duration() {
	var ritmos = '';
	
	$('#escolha-ritmo .tampinha').each(function() {
		if($(this).hasClass('active')) {
			ritmos = ritmos + $(this).data('genre') + ',';	
		}
	});
	
	$('#input_ritmo').val(ritmos.substring(0,(ritmos.length - 1)));
	
	if($('#input_ritmo').val().length) {
		$('#escolha-ritmo').hide();
		$('#escolha-duracao').fadeIn();		
		$('#form_cria_playlist').fadeIn();
	}
}

function cria_playlist() {
	
	
	
}

