<!--<link rel="stylesheet" href="/sites/all/themes/framework/css/estilos_vendedor.css">-->
<link rel="stylesheet" href="/sites/all/themes/framework/css/estilosJesu.css">
<link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
<?php 
	//Cargamos la imagen (logo) del vendedor
	$file_foto = $node->field_foto["und"][0]["uri"];
	$ruta_imagen1=image_style_url('300x300', $file_foto);        
?>
	<div class='Header_nvendedor'>
		<div class='Logo_nvendedor'>
			<img style="" src=" <?php echo $ruta_imagen1 ?>"/>

		</div>
		<div class='Descripcion_nvendedor' style="height:500px;">
            
             
			<h1><?php echo $node->title ?></h1><br><br> 
			<strong>Sitio web:</strong>
            <?php
            print (isset($node->field_facebook["und"][0]["value"])) ? $node->field_facebook["und"][0]["value"] : ''; 
            ?> <br> <br> 
			<strong>Dirección:</strong> <?php echo $node->field_direccion["und"][0]["value"] ?> <br> <br> 
			<strong>Teléfono:</strong> <?php echo $node->field_telefono["und"][0]["value"] ?> <br><br>
            <strong>Instagram:</strong> <?php echo $node->field_instagram["und"][0]["value"] ?> <br><br>
            <strong>Twitter:</strong> <?php echo $node->field_twitter["und"][0]["value"] ?> <br><br>
            <strong>Youtube:</strong> <?php echo $node->field_youtube["und"][0]["value"] ?> <br><br>
			<strong>Horario:</strong> 08:00 am - 20 pm <br><br>
			<div style="float:left"><h2>Síguenos:</h2></div> 
            
            <div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/facebook_boton.png"> </a></div>
            <div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/youtube_boton.png"> </a></div>
            <div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/twitter_boton.png"> </a></div>
			<!--<div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/tw.jpg"></a></div>-->
			<!--<div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/ig.jpg"></a></div>-->
			<!--<div class='Social_nvendedor'><a href=""><img src="/sites/all/themes/framework/img/yt.jpg"></a></div>-->
		</div>

		<div class='Eventos_nvendedor'>

		</div>
	</div>
	<div>
	<?php 
   //	echo print views_embed_view('node_vendedor','block_1');
	?>
	</div>