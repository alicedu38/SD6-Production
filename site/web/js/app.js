$( document ).ready(function(){
	/*------General------*/
	/*Ombres hover*/
	/*$(".annonce [class*='col-'] .contenu").hover(
		function(){$(this).toggleClass("ombres");}
	);*/

	$(".production [class*='col-']").hover(
    function(){$(this).addClass("zoom-effet");}
  );

	/*------liste annonces------*/
	/*Change les balises accroche annonce en p*/
	$( ".annonce div[class^='col-'] .contenu .accroche" ).children().each(function(index){
		$(this).replaceWith($('<p>' + $(this).text() + '</p>'))
	})


	/*------Visuel gallerie photos------*/
	$(document).on('click','links', function() {
		event = event || window.event;
		var target = event.target || event.srcElement,
		link = target.src ? target.parentNode : target,
		options = {index: link, event: event},
		links = this.getElementsByTagName('a');
		blueimp.Gallery(links, options);
	});
})
