<?php

//echo "<pre>"; print_r($variables); echo "</pre>";
//hide($content['main_front']);

// echo "<pre>";print_r($node);echo "</pre>";
$description = array(
'#tag' => 'meta',
'#attributes' => array(
'property' => 'description',
'content' => "Lo mejor de los productos Anime en Colombia, tiendas como: Dnk Cute Shop, Taiyou Anime, Hiroshima Boom ¡ya estan aquí!",
));
drupal_add_html_head($description, 'description');

$og_description = array(
'#tag' => 'meta',
'#attributes' => array(
'property' => 'og:description',
'content' => $node->body["und"][0]["value"]));
drupal_add_html_head($og_description, 'description');

$imagen = $node->field_foto["und"][0]["uri"];
$imagen=image_style_url('200x200', $imagen);

$og_image = array(
'#tag' => 'meta',
'#attributes' => array(
'property' => 'og:image',
'content' => $imagen)); 
drupal_add_html_head($og_image, 'og:image');?>

<!--<link rel="stylesheet" href="/sites/all/themes/framework/css/estilos_vendedor.css">-->
<link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
<?php 
//Cargamos la imagen (logo) del vendedor
$file_foto = $node->field_foto["und"][0]["uri"];
$ruta_imagen1=image_style_url('220x220', $file_foto);?>

<?php 
// $usuarioAdmin=false;
// echo "if (".$user->uid."==".$node->field_usuario_gestion_compras["und"][0]["value"];
$usuarioAdmin=false;
if ($user->uid !=0 and $user->uid==$node->field_usuario_gestion_compras["und"][0]["value"]) {
    $usuarioAdmin=true;
} else{
    $usuarioAdmin=false;
}
$verEvento=$node->field_mostrar_proximo_evento["und"][0]["value"];
$galeria=$node->field_galeria["und"][0]["nid"];
// echo "<pre>"; print_r($user); echo "</pre>";
if ($usuarioAdmin==true){?>
    <div id="admin_vendedor">
        <?php
        print views_embed_view('vendedor','block_7');
        print views_embed_view('vendedor','block_6');?>
    </div>
    <?php
}


// echo "La galeria es:".$idGaleria;
?>
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
                <?php
                print_r($node->body["und"][0]["value"]);
                ?>
            </p>
            <!-- <strong>Instagram:</strong> <?php // echo $node->field_instagram["und"][0]["value"] ?> <br><br><br> -->
            <!--<strong>Twitter:</strong>  echo $node->field_twitter["und"][0]["value"] <br><br>-->
            <!--<strong>Facebookr:</strong> // echo $node->field_facebook["und"][0]["value"]  <br><br>-->
            <!--<strong>Youtube:</strong>  echo $node->field_youtube["und"][0]["value"] <br><br> -->
        </div>
    </div>
    
    <?php
    if ($verEvento) {?>
    	<div style="" class='eventos_nvendedor'>
            <h2>Próximos eventos</h2> <br><br>
            <?php print views_embed_view('vendedor','block_2');?>
    	</div>
        <?php
    }?>

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

<?php
    if (isset($galeria)){//Imprimiendo la galeria
        print views_embed_view('vendedor','block_8');
    }

    if (!$verEvento) {?>
        <style>
            .node-type-vendedor .noticias_destacadas{
                clear: none;
            }
            .node-type-vendedor .productos_destacados{
                margin-top: 20px;
            }
            .node-type-vendedor .listado_productos{margin-top: 0;}
            .view-id-vendedor.view-display-id-block_5 .view-content{width: auto;}
        </style>
        <?php 
    }
?>