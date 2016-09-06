function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return x;
}


$(document).ready(function(){
	$("#btn_ingreso_tiendas").click(function(){
		$(this).hide();
		$("form#user-login").fadeIn();
	});
	$(".bloque-info-sup").addClass('animated zoomInLeft', "", function(){
	});
	$(".bloque-info-sup a").fadeIn();
	// Popup suscripcion
		if($("body").width()>=1000){
			cookieSuscripcion=getCookie("suscripcion");
			if (cookieSuscripcion!="true") {
				setTimeout(function(){
					$(document).colorbox({inline:true, href:"#formSuscribetePOPUP", open:true, onComplete:function(){
						$(".letrero-ama").addClass('animated tada');		
						setCookie("suscripcion", "true", "1");
					}});
				}, 5000);
			}


			$("#formSuscribetePOPUP form button").click(function(e){
				e.preventDefault();
				datos=$("form#datos").serialize();
				$.ajax({
					url:"/sites/all/themes/framework/enviar-correo-suscripcion.php",
					data:datos,
					type:"POST",
					success:function(res){
						console.log(res);
						setCookie("suscripcion", "true", "30");
					}
				});
				$(".letrero-verde").css("display", "block");
			});
		}
	// Fin popup suscripcion
	$(window).on('scroll', function() {
		if (isMobile!="1") {
			if($(window).scrollTop() > 0) {
				$("#header").addClass("scrollDifrCro");
				$("html body .container").addClass("scrollDifrCro");
				} else {
				$("#header").removeClass("scrollDifrCro");
				$("html body .container").removeClass("scrollDifrCro");
			}
		}
    });
});


function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}