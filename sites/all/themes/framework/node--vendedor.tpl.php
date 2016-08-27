<!--<link rel="stylesheet" href="/sites/all/themes/framework/css/estilos_vendedor.css">-->
<link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
<?php 
//Cargamos la imagen (logo) del vendedor
$file_foto = $node->field_foto["und"][0]["uri"];
$ruta_imagen1=image_style_url('220x220', $file_foto);?>
<div class='header_nvendedor'> 
    <div id="info_nvendedor">
	    <div class='logo_nvendedor'>
            <img style="" src=" <?php echo $ruta_imagen1 ?>"/>
            <div class='social_nvendedor'>
                <div>
                    <a target="_blank"  href="<?php echo $node->field_twitter['und'][0]['value']?>"> 
                        <img style=" height: 40px ; width: 40px;" src="/sites/all/themes/framework/img/twitter_boton.png"> 
                    </a>
                </div>
                
                <div>
                    <a target="_blank"  href="<?php echo $node->field_youtube['und'][0]['value']?>">
                        <img style=" height: 40px; width: 40px;" src="/sites/all/themes/framework/img/youtube_boton.png">
                    </a>
                </div>
                
                <div>
                    <a target="_blank"  href="<?php echo $node->field_facebook['und'][0]['value']?>">
                    <img style=" height: 40px; width: 40px;"src="/sites/all/themes/framework/img/facebook_boton.png"></a>
                </div>
            </div>
        </div>

    	<div class='descripcion_nvendedor'>
            <h1><?php echo $node->title ?></h1>
            <p>
    		  <strong>Dirección:</strong> <?php echo $node->field_direccion["und"][0]["value"] ?>
            </p>
            <p>
    		  <strong>Teléfono:</strong> <?php echo $node->field_telefono["und"][0]["value"] ?>
            </p>
            <p>
                <strong>Horario:</strong> 08:00 am - 20 pm
            </p>
            <!-- <strong>Instagram:</strong> <?php // echo $node->field_instagram["und"][0]["value"] ?> <br><br><br> -->
            <!--<strong>Twitter:</strong>  echo $node->field_twitter["und"][0]["value"] <br><br>-->
            <!--<strong>Facebookr:</strong> // echo $node->field_facebook["und"][0]["value"]  <br><br>-->
            <!--<strong>Youtube:</strong>  echo $node->field_youtube["und"][0]["value"] <br><br> -->
        </div>
    </div>
    

	<div style="" class='eventos_nvendedor'>
        <h2>Próximos eventos</h2> <br><br>
        <?php print views_embed_view('vendedor','block_2');?>
	</div>

    <div class='noticias_destacadas'>
        <h2>Noticias destacadas</h2>
        <?php print views_embed_view('vendedor','block_4');?>
    </div>

    <div class='productos_destacados'>
        <h2>Producto estrella</h2>
       <?php print views_embed_view('vendedor','block_3');?>
    </div>

    <div class="listado_productos">
       <?php print views_embed_view('vendedor','block_5');?>
    </div>
</div>