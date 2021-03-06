/* Javascript Navegação */

$(document).ready(function() {
	$('.acao').click(function(e) {
		var elementos = document.getElementsByClassName('acao');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "acao";
		}

		this.className = "acao selecionado";
		e.preventDefault(); // Previne o Comportamento padrão do Link
		var exibir = this.href.split('#'); // Recebe a Página para Navegação

		$('section').hide(); // Esconde Páginas
		$('.aparelho').fadeIn(700); // Exibe Página Selecionada
		$('#'+exibir[1]).fadeIn(700);

		var ultimo = 1;

		$('#'+exibir[1]).html('<div class="spinner nofloat"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
	    // Faz requisição ajax e envia o ID da Categoria via método POST
	   
	    $.post("./sections/"+exibir[1]+".php", {ultimo: ultimo}, function(resposta) {
	       // Coloca a resposta na DIV
	       setTimeout(function() { $('#'+exibir[1]).html(resposta); }, 340);
	   
	    });

	});


	$('#backToTop').click(function() {
		$('html, body').animate({ scrollTop: 0 }, 800);
	});

	$( window ).scroll(function() {
		if($( window ).scrollTop() > 1240) 	$('#backToTop').fadeIn();
		else $('#backToTop').fadeOut();
	});



	$( window ).scroll(function() {
		if($( window ).scrollTop() > 75) {
			$('nav').css('position', 'fixed');
			$('nav').css('top', '0px');
			$('#logoInterno').css('position', 'fixed');
			$('#logoInterno').css('z-index', '9999');
			$('#logoInterno').css('top', '4px');
			$('#logoInterno').css('left', '0px');
			$('#logoInterno').css('margin-left', '0px');
			$('#logoInterno').css('width', '116px');
			$('#logoInterno').css('background', 'rgb(51, 51, 51');
			$('#logoInterno').css('padding', '10px 12px');
			$('nav').css('z-index', '9997');  
		}
		else {
			$('nav').css('position', 'relative');
			$('#logoInterno').css('z-index', '9999');
			$('#logoInterno').css('position', 'relative');
			$('nav').css('z-index', '9997');
			$('#logoInterno').css('top', '0px');
			$('#logoInterno').css('width', '133px');
			$('#logoInterno').css('margin-left', '12px');
			$('#logoInterno').css('background', 'transparent');
			$('#logoInterno').css('padding', '0px');
		}
	});
	
});