	<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="/themes/framework/assets/css/nouislider.tooltips.css">
	<link rel="stylesheet" type="text/css" href="/themes/framework/assets/css/nouislider.pips.css">
	<link rel="stylesheet" type="text/css" href="/themes/framework/assets/css/nouislider.min.css">
	<script src="/themes/framework/assets/js/jquery-ui-slider-pips.js"></script>
	<script src="/themes/framework/assets/js/nouislider.min.js"></script>
	<link rel="stylesheet" href="/themes/framework/assets/css/jquery-ui-slider-pips.css">
	<div id="main-home">
		<div class="slider-block listado-proyectos">
			<h1>Resultados de busqueda</h1>
			<div class="content-filtro">
				<div class="filtro">
                    <button class="filtro-movil">Ver herramientas de búsqueda</button>
					
				    <?php
				    if ($exposed): ?>
				    	<div class="view-filters"><?php print $exposed; ?></div>
				    	<?php 
				    endif;  
				    if ($attachment_before): ?>
				    	<div class="attachment attachment-before"><?php print $attachment_before; ?></div>
				    	<?php 
				    endif;?>
				</div>
			</div>
			<?php
		    if ($rows): ?>
		    	<div class="view-content result-search"><?php print $rows ?></div><?php elseif ($empty): ?><div class="view-empty"><?php print $empty; ?></div>
		    	<?php 
		    endif;?>
		</div>  
	</div>
</div><!--back-container-->

<?php 
//echo "<pre>";print_r($_GET);echo "</pre>";
?>

<script>
jQuery(function ($) { 
  $(document).ready(function () {
      $( ".views-field.views-field-field-apartamentos-desde .field-content" ).each(function( index ) {
 	     valor=$(this).html();
 		 valor=valor.split("$");
 		 valor=numberWithCommas(valor[1]);
 		// console.log(valor);
 		  $( ".views-field.views-field-field-apartamentos-desde .field-content" ).html("$"+valor)
		});
    });
});

	var valor_desde="<?php echo $_GET["field_apartamentos_desde_value"]["min"];?>";
	var valor_hasta="<?php echo $_GET["field_apartamentos_desde_value"]["max"];?>";
	valor2_desde=numberWithCommas(valor_desde);
	valor2_hasta=numberWithCommas(valor_hasta);
	valor_corto_desde=valor_desde*0.000001;
	valor_corto_hasta=valor_hasta*0.000001;
	if (valor_corto_desde==null || valor_desde==null) {valor_corto_desde=0;}
	if (valor_corto_hasta==null || valor_hasta==null) {valor_corto_hasta=0;}

	if (valor_hasta==10000000000) {
		$("#edit-field-apartamentos-desde-value-wrapper label").html("Propiedades desde <br> <span> $"+valor2_desde+" </span><br>");
	} else{
		$("#edit-field-apartamentos-desde-value-wrapper label").html("Propiedades desde <br> <span> $"+valor2_desde+" </span> hasta <span> $"+valor2_hasta+"</span><br>");
	}

	function numberWithCommas(x) {
	    x = x.toString();
	    var pattern = /(-?\d+)(\d{3})/;
	    while (pattern.test(x))
	        x = x.replace(pattern, "$1,$2");
	    return x;
	}

	var connectSlider;
	$(document).ready(function(){
        /*btn ver filtro*/
        var filtromovil=false;
        $(".filtro-movil").click(function(){
            if(filtromovil==false){
                $(this).html("Ocultar herramientas de búsqueda");
                $(".view-filters").slideDown();
                filtromovil=true;
            } else{
                $(this).html("Ver herramientas de búsqueda");
                $(".view-filters").slideUp();
                filtromovil=false;
            }
        });
        
		/*menu-fijo*/
		var obj = $('.filtro');
	    var contenedor = $('.view-content result-search');
	    var menu_offset = obj.offset();
	    $(window).on('scroll', function() {
	      if($(window).scrollTop() > menu_offset.top) {
	        obj.addClass('fijo');
	        } else {
	        obj.removeClass('fijo');
	      }
	    });

	    $(".filtro  #edit-field-apartamentos-desde-value-wrapper").append('<div id="slider-ui"></div>');
	    /*Slide despues*/
	    html5Slider = document.getElementById('slider-ui');
		noUiSlider.create(html5Slider, {
			start: [valor_corto_desde, valor_corto_hasta],
			connect: true,
			behaviour: 'tap',
			range: {
				'min': 50,
				'max': 300
			},
			pips:{
				mode:"values",
				values:[50, 300],
				density:4
			}
		});

		/*Cambiando label de la barra slider range*/
		$(".noUi-pips.noUi-pips-horizontal div").each(function(){
			console.log($(this).html());
			if ($(this).html()=="50") {
				$(this).html("Min.");
			}
			if ($(this).html()=="300") {
				$(this).html("Max.");
			}
		});
		/**/



		//var inputNumber = document.getElementById('input-number');

		html5Slider.noUiSlider.on('update', function( values, handle ) {
			//console.log(values+" "+handle);
			//var value = values[handle];
			console.log(values);
	    	valor_desde3=parseInt(values[0]);
	    	valor_hasta3=parseInt(values[1]);
	    	//Cambiando el valor del input hasta
	    	if (valor_hasta3==300) {
	    		$(".filtro #edit-field-apartamentos-desde-value-max").val("10000000000");	//Sin limite
	    		$(".filtro #edit-field-apartamentos-desde-value-wrapper label").html("Propiedades desde <br> <span> $"+valor_desde3+".000.000 </span>");
	    	} else{
	    		$(".filtro #edit-field-apartamentos-desde-value-max").val(valor_hasta3+"000000");
	    		$(".filtro #edit-field-apartamentos-desde-value-wrapper label").html("Propiedades desde <br> <span> $"+valor_desde3+".000.000 </span> hasta <span> $"+valor_hasta3+".000.000 </span><br>");
	    	}
	    	//Cambiando el valor del input desde
	    	$(".filtro #edit-field-apartamentos-desde-value-min").val(valor_desde3+"000000");
			
		});
		/*
		select.addEventListener('change', function(){
			html5Slider.noUiSlider.set([this.value, null]);
		});

		inputNumber.addEventListener('change', function(){
			html5Slider.noUiSlider.set([null, this.value]);
		});*/

	    $(".filtro #edit-submit-buscar").attr("value", "Actualizar Búsqueda");
	    $(".filtro #edit-field-estrato-value option:nth-child(1)").html("Seleccionar");
	    $(".filtro #edit-field-garaje-value option:nth-child(1)").html("Seleccionar");
	    $(".filtro #edit-field-numero-de-habitaciones-value option:nth-child(1)").html("Seleccionar");
	    $(".filtro #edit-field-tipo-de-inmueble-tid option:nth-child(1)").html("Seleccionar");
	    $(".filtro #edit-field-empresa-tid option:nth-child(1)").html("Seleccionar");
	    $(".filtro #edit-field-numero-de-banos-value option:nth-child(1)").html("Seleccionar");
	});/*Document ready*/
</script>

<style>
	.page-buscador #main-home .listado-proyectos{min-height: 890px;}
	.page-buscador .filtro{top: 0;}
	/*.fijo{position: fixed;}*/
	.form-item-field-apartamentos-desde-value-max label{display: none;}
	#edit-field-estrato-value-wrapper{margin-top: 40px;}
	.ui-slider-float .ui-slider-tip{width: 84px; margin-left: -42px;}
	#main-home .listado-proyectos{background: #fff;}
	.slider-block input[type=submit]{display: block;}
	#main-home .listado-proyectos{text-align: left;}
	#edit-field-apartamentos-desde-value-min, #edit-field-apartamentos-desde-value-max{display: none;}
	.views-exposed-form .views-exposed-widget{float: none;}
	.back-container{min-height: 795px;}
</style>