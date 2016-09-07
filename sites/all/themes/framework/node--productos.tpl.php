  <?php
  // echo "<pre>";print_r($node);echo "</pre>";
  $description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'description',
  'content' => "Lo mejor de los productos Anime en Colombia, tiendas como: Dnk Cute Shop, Taiyou Anime, Hiroshima Boom ¡ya estan aquí!",
  ));
  drupal_add_html_head($description, 'description');

  if (isset($node->field_sumario["und"][0]["value"])) {
    $sumario=$node->field_sumario["und"][0]["value"];
  }
  $og_description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:description',
  'content' => $sumario));
  drupal_add_html_head($og_description, 'description');

  $og_image = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:image',
  'content' => "http://colombianime.com/sites/default/files/".$node->field_imagenes["und"][0]["filename"])); 
  drupal_add_html_head($og_image, 'og:image');

  $path="http://colombianime.com/".drupal_get_path_alias();?>
  <link rel="stylesheet" type="text/css" href="sites\all\themes\framework/node--productos.css">
  <div class="popup popup-detalle-contacto">
    <div class="fondo_blanco">
      <button class="close" id="cboxClose" onclick="javascript:$('.popup').fadeOut();"></button>
      <?php $view = views_get_view('node_productos'); print $view->preview('block_3'); ?>
      <p id="msg_pop_compra">
        Ingresa con tus datos y te regalamos descuentos ^^
      </p>

      <div id="status_web"></div>

      <form id="enviar_compra">
        <div id="login_cliente">
          <div>
            <input type="text" id="inp_correo" name="correo" placeholder="Correo electronico">
          </div>
          
          <div>
            <input type="password" name="pin" id="pin" placeholder="Escribe aquí tu PIN">
          </div>
          <a href="#" onclick="recordar_contrasena();" id="btn_recordarpass">Recordar mi PIN</a>
          <input type="button" onclick="check_correo()" class="btn-estilos-v1" value="Comprobar" />

          <div style="clear:both;"></div>
          <!-- <p>
            <a onclick="btn_registrate()">¿No tienes pin :O? no te preocupes, solo da click Aquí y obtén el tuyo</a>
          </p> -->
        </div>
        <div id="info_cliente">
          <table align="center">
            <tr>
              <td><input type="text" name="nombre" placeholder="Nombre"></td>
              <td> <input type="text" name="apellidos" placeholder="Apellidos"></td>
            </tr>
            <tr>
              <td><input type="text" name="telefono" placeholder="Telefono/Celular"></td>
              <td><input type="text" name="cedula" placeholder="Cedula" id="inp_cedula"></td>
            </tr>
            <tr>
              <td>
                <input type="text" name="direccion" placeholder="Dirección y barrio">
              </td>
            </tr>
          </table>
          <label style="margin: 10px 0 0;" class="info">La dirección la utilizamos para los pedidos a domicilio</label>
          <input type="button" name="" value="Siguiente" class="btn-estilos-v1 btn-siguiente">
        </div>

        <div id="info_compra">
          <div style="margin: 10px 0; text-align: center;">
            <input type="radio" name="field_tipo_entrega" value="Ir a la tienda" checked> Ir a la tienda
            <input type="radio" name="field_tipo_entrega" value="Domicilio"> Envío a domicilio
          </div>
          <div class="espacio-bono">
            <label>Aplicar bono</label>
            <input type="text" name="bono" id="bono">
            <input onclick="aplicar_bono()" type="button" value="Aplicar" class="aplicar_bono" />
          </div>
          <div class="total-compra">
            <table align="center" style="margin: 0 auto;  width: 140px;">
            <tr class="bono" style="display:none;">
              <td class="label">Bono</td><td class="val" style="color: #01b000;"></td>
            </tr>
              <tr>
                <td class="label">Total</td><td><label class="precio"></label></td>
              </tr>
            </table>
            <input type="button" onclick="enviar_compra()" value="Terminar compra" class="btn-estilos-v1 btn-terminar-compra">
          </div>
        </div>
        <input type="hidden" name="origen" value="check_correo">
        <input type="hidden" name="id_producto" value="<?php echo $node->vid?>">
        <input type="hidden" name="nombre_producto" value="<?php echo $title ?>">
        <input type="hidden" name="inp_tienda" id="inp_tienda" value="<?php echo $node->field_vendedor['und'][0]['nid']?>">
        <input type="hidden" name="field_usuario_gestion_compras" value="<?php echo $node->field_vendedor['und'][0]['node']->field_usuario_gestion_compras['und'][0]['value'] ?>">
      </form>
      
      <div class="nota-2">
      </div>

      <div class="nota">
        Al comunicarte menciona que viste el articulo en Colombianime ^^
      </div>
    </div>

  </div>

  <div class="columnas columna-node-producto">
    <?php

    //require_once ('../sites/all/libraries/mobile-detect-master/mobile_detect.php');
    //$detect = new Mobile_Detect();
    if ($_SESSION["isMobile"]==1) {?>
      <section class="col-der movil"> <!-- Fotos en movil -->
        <div class="items-fotos">
          <?php
          foreach ($node->field_imagenes["und"] as $key => $value) { //Recorriendo el campo de las imágenes
            $filename=$value["uri"];
            $ruta_imagen=image_style_url('500x500_detalle_producto', $filename);
            echo "<img src='".$ruta_imagen."' />";
          }
          ?>
        </div>
      </section>
      <?php
    }?>

    <section class="col-izq">
      <article>
        <!-- <p class="title-columna">
    		<?php print $title;?>
        </p> -->
        <?php print render($content['body']);?>
        <div class="foto-vendedor">
          <?php $view = views_get_view('node_productos'); print $view->preview('block_1'); ?>
        </div>

        <div class="espacio-accion">
      		<?php print render($content['field_precio']);?>

          <button class="btn-comprar" onclick="javascript:$('.popup').fadeIn();">Lo quiero!</button>
          
          <div class="redes">
            <div class="fb-like" data-href="<?php echo $path;?>" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true" class="share-facebook"></div>
            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title;?> <?php echo $path;?>" class="share-twitter">
            colombianime
            </a>
          </div>
        </div>
      </article>

      <article style="background: #FFFAF1; border-radius: 5px; margin-right: 5px;">
        <div data-width="450" class="fb-comments" data-href="<?php echo $path;?>" data-numposts="5"></div>
      </article>
    </section>

    <?php
    if ($_SESSION["isMobile"]!=1) {?>
      <section class="col-der desktop">
        <div class="items-fotos">
        	<?php
          foreach ($node->field_imagenes["und"] as $key => $value) { //Recorriendo el campo de las imágenes
            $filename=$value["uri"];
            $ruta_imagen=image_style_url('500x500_detalle_producto', $filename);
            echo "<img src='".$ruta_imagen."' />";
          }
    	    ?>
        </div>
      </section>

      <section class="desktop mas-productos">
        <?php $view = views_get_view('node_productos'); print $view->preview('block_6'); ?>
      </section>
      <?php
    }?>

    <div class="spacer" style="clear: both;"></div>
  </div><!-- columnas -->
  <?php
  require_once("sites/all/themes/framework/no-tienes-cuenta.html");
  ?>
</div><!-- container que abro en html.tpl-->

<script type="text/javascript" src="sites\all\themes\framework/node--productos.js"></script>