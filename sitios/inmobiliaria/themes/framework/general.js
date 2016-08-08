var tempRedes_mobile=true;
var tempNav_mobile=true;
var logo_menu;
$(function() {
	$(".bt-menu").click(function(){
		if (tempNav_mobile==false) {
		  $("#nav_mobile").slideUp();
		    tempNav_mobile=true;
		} else{
		  $("#nav_mobile").slideDown();
		  tempNav_mobile=false;
		}
	});

	 $("#btn_redes").click(function(){
		if (tempNav_mobile==false) {
	    	$(".google_redes").slideUp();
		    tempNav_mobile=true;
		} else{
	    	$(".google_redes").slideDown();
		  tempNav_mobile=false;
		}
	});

	/*Menu fixed*/
		var menu = $('.menu-feria');
		logo_menu = $('.logo-menu');
		var contenedor = $('.container-menu');
		var menu_offset = menu.offset();
		$(window).on('scroll', function() {
			if($(window).scrollTop() > menu_offset.top) {
				$(".div01").addClass('menu-fijo');
				logo_menu.addClass('visible');
				$("ul.menu-feria li .href-inicio").addClass("oculto");;
				$("header").addClass("anchox100porc");
				$(".container-menu").addClass("anchox100porc");
			} else {
				$(".container-menu").removeClass("anchox100porc");
				$("header").removeClass("anchox100porc");
				$("ul.menu-feria li .href-inicio").removeClass("oculto");;
				logo_menu.removeClass('visible');
				logo_menu.addClass('animated fadeInDown');
				$(".div01").removeClass('menu-fijo');
			}
		});
	/*Fin menu fixed*/
});