  <?php
  if (isset($node->field_sumario["und"][0]["value"])) {
    $sumario=$node->field_sumario["und"][0]["value"];
  }
  $og_description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:description',
  'content' => $sumario));
  drupal_add_html_head($og_description, 'description');

  $filename=$node->field_imagenes["und"][0]["uri"];
  $ruta_imagen=image_style_url('300x300', $filename);

  $og_image = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:image',
  'content' => $ruta_imagen)); 
  drupal_add_html_head($og_image, 'og:image');
  
  $path="http://colombianime.com/".drupal_get_path_alias();?>
  <div class="AnuncioGoogle Anu320x100 AnuArticulo">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Flotante articulo -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:320px;height:100px"
         data-ad-client="ca-pub-4730353912478910"
         data-ad-slot="2850501582"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

  <div class="columnas columna-node-article">
    <?php
    if(isset($_SESSION["isMobile"])){
	    if ($_SESSION["isMobile"]!=1) {?>
	      <section class="col-izq">
	        <article>
	          <?php print views_embed_view('node_productos','block_2'); ?>
	        </article>
	      </section>
	      <?php
	    }
    }?>

    <section class="col-der">
      <div class="header">
        <?php 
        //echo "<pre>";print_r($node->field_imagenes);echo "</pre>";
        //echo "<hr>";
        foreach ($node->field_imagenes["und"] as $key => $value) { //Recorriendo el campo de las imágenes
          $filename=$value["uri"];
          $ruta_imagen=image_style_url('800x210', $filename);
          echo "<img style='display: none !important;' src='".$ruta_imagen."' />";
        }
          //$filename=$value["uri"];
          //$ruta_imagen=image_style_url('500x500_detalle_producto', $filename)."<br>";
        ?>

        <h1 class="titulo">
          <?php echo $title;?>
        </h1>
      </div>

      <?php print views_embed_view('node_productos','block_4'); ?>

      <?php echo render($content["body"]);?>
        <div class="redes">
          <div class="fb-like" data-href="<?php echo $path;?>" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true" class="share-facebook"></div>
          <!-- <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title;?> <?php echo $path;?>" class="share-twitter">
          colombianime
          </a> -->
        </div>

      <div class="autor_inf">
        <?php print views_embed_view('node_productos','block_4'); ?>
      </div>

      <div data-width="612" class="fb-comments" data-href="<?php echo $path;?>" data-numposts="5"></div>

    </section>
    <div class="spacer" style="clear: both;"></div>
    
  </div>
  <?php
  require_once("sites/all/themes/framework/no-tienes-cuenta.html");
  ?>
</div><!-- container que abro en html.tpl-->

<style>
  .header{
    background-image: url(<?php echo $ruta_imagen?>);
    width:100%;
    background-size: cover;
    height: 210px;
    position: relative;

  }
  .title{
    display: none;
  }
  .header .titulo{
    background: rgba(62, 62, 62, 0.85);
    text-transform: uppercase;
    position: absolute;
    bottom: 0;
    padding: 7px 12px;
    text-align: left;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
  }
  .field-name-body{
    /*color: #7c7c7c;*/
    color: #5A5A5A;
    font-size: 16px;
    margin: 20px 10px 0 0;
    letter-spacing: 0.5px;
    line-height: 22px;

  }
  .field-name-body p{
    margin: 20px 0px;
  }
  .field-name-body a{
    color: #DE8C0B;
  }
  p.img-anuncio {
    background: rgba(243, 243, 243, 0.89);
    padding: 10px 0 15px;
  }
  p.img-anuncio span{
  margin: -10px 0 10px;
  display: block;
  background: #CECECE;
  color: #fff;
  padding: 2px 0px 2px 5px;
  font-size: 14px;
  }
  #page-wrapper{
    overflow: hidden;
  }

  html body .container .columna-node-article section.col-der{margin-right: 3px;}
  html body .container{padding-top: 60px;}
  html body .container section.col-izq .views-field-title a{
    text-transform: uppercase;
    padding: 7px 12px 0 0;
    text-align: left;
    color: #1b2c3f;
    font-size: 18px;
    font-weight: 500;
  }
  html body .container section.col-izq .views-field-title hr{
  height: 2px;
  background: #F3951A;
  border: none;
  margin: 20px 0;
  width: 160px;
  box-shadow: -70px 0px 0 rgb(255, 203, 134) inset;
  }
  .item-producto{text-align: left; width: 240px;}
  .item-producto a{font-size: 16px; color: #fff;}
  .item-producto{width: auto;}
  .item-producto div:nth-child(2){display: inline-block; vertical-align: top;}
  .item-producto div:nth-child(2) a{display: block; text-align: center;}
  .item-producto div:nth-child(3){display: inline-block; vertical-align: top;    margin: 10px 0; color: #7c7c7c; line-height: 20px;}
  .item-producto div:nth-child(3) .sumario{ margin: 10px 0 0 10px; font-size: 14px;}

</style>