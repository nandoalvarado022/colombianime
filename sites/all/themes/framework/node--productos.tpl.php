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

<script>
  // Efectos visuales
    $("#info_cliente input[type='button']").click(function(){
      status_web("Actualizando tus datos ...");
      $(this).parent().fadeOut(function(){
        console.log("Termino.");
        $("#msg_pop_compra").html("");
        $("#info_compra").fadeIn();
      });
      //Guardando/Actualizando datos del cliente
      $(".popup-detalle-contacto form input[name='origen']").val("save_info_cliente");
      datos=$(".popup-detalle-contacto form#enviar_compra").serialize();
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          $(".popup-detalle-contacto form input[name='origen']").val("enviar_compra");
          status_web("Si tienes un <b>cupon de descuento</b> pegalo en el cuadro amarillo de abajo y da clic en aplicar ^^");
        }
      });


    });
  // General
    effects=Array("tada", "bounce", "wobble", "bounceIn", "flip");
    window.setInterval(function(){
      animation=effects[Math.floor(Math.random() * effects.length)];//aleatorio
      element = $(".btn-comprar");
      element.addClass('animated ' + animation);
      //wait for animation to finish before removing classes
      window.setTimeout( function(){
          element.removeClass('animated ' + animation);
      }, 2000);
    }, 4000);

    $(document).ready(function() {
      ajustarPopupDetalleContacto(520);
    	$(".items-fotos").owlCarousel({
          autoPlay: 3000,
          items : 1,
          itemsDesktop : [1199,1],
          itemsDesktopSmall : [979,1]
    	});

      precio=$(".field-name-field-precio .field-item").html();
      precio=numberWithCommas(precio);
      $(".field-name-field-precio .field-item").html(precio);
      $("#enviar_compra .precio").html(precio);
  	});
  // Fin general

  // Compras
    var clienteID;
    var bonoCODIGO;
    var bonoID;
    var bonoVAL;
    var precioTotal=<?php echo $node->field_precio["und"][0]["value"]?>;
    var productoID=<?php echo $node->nid?>;
    var tiendaID=<?php echo $node->field_vendedor['und'][0]['nid']?>;

    function validarEmail(email) {
      if (email=="") {
        alert("Escribe tu correo electronico.");
        return false;
      }
      expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if ( !expr.test(email) ){
        alert("Correo electronico no valido.")
        return false;
      } else{
        return true;
      }
    }

    function recordar_contrasena(){
      email=$("#inp_correo").val();
      res=validarEmail(email);
      if (res==false) {
        return false;
      }
      
      $.ajax({
        dataType: "html",
        url:"/ajax-productos",
        data:{
          "correo": $("#inp_correo").val(),
          "origen": "recordar_pass"
        },
        type:"POST",
        success:function(res){
          alert(res);
        }
      });
    }

    function aplicar_bono(){
      status_web("Cargando ...");
      datos="bono="+$("#bono").val()+"&origen=aplicar_bono&cedula="+$("#inp_cedula").val()+"&inp_tienda="+$("#inp_tienda").val()+"&productoID="+productoID;
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          console.log(res);
          res=JSON.parse(res);
          console.log(res);
          if (res.id!=0) {
            bonoID=res.id;
            bonoVAL=res.valor;
            bonoCODIGO=res.codigo;
            status_web("Se aplico un descuento a tu compra.");
            precio=$("#enviar_compra .precio").html();
            precio=precio.replace(".", "");
            if (precio>bonoVAL) {
              precio=precio-bonoVAL;
            } else{
              precio=0;
            }
            precioTotal=precio;
            precio=numberWithCommas(precio);
            $("#enviar_compra .precio").html(precio);
            $("#bono").attr("disabled", "disabled");
            $("#bono").css("background", "#efefef");
            $(".aplicar_bono").fadeOut();
            get_valor_bono(bonoCODIGO);
            $("tr.bono").fadeIn();
          } else{
            status_web("No se ha podido conjear tu bono.");
          }
        }
      });
    }

    function get_valor_bono(codigo_bono){
      datos="origen=get_valor_bono&codigo_bono="+codigo_bono;
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          
          $("tr.bono .val").html("- $"+numberWithCommas(res));
        }
      });
    }

    function btn_registrate(){
      $("#crear_cliente").fadeIn();
      $("#login_cliente").hide();
    }

    function status_web(e){
      $("#status_web").html(e)
      .addClass('animated tada');
      window.setTimeout( function(){
      $("#status_web").removeClass('animated tada');
      }, 1000);
    }

    function crear_cliente(){
      status_web("Enviando correo ...")
      datos=$("#crear_cliente").serialize();
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          status_web("Se ha creado tu cuenta ^^");
          $("#crear_cliente").hide();
          $("#login_cliente").fadeIn();
        }
      });
    }

    function check_correo(msg){
      email=$("#inp_correo").val();
      res=validarEmail(email);
      if (res==false) {
        alert("Correo electronico no valido.")
        return false;
      }

      $("#btn_recordarpass").show();
      //$(".popup-detalle-contacto form input[name='origen']").val("check_cliente");
      //status_web("Ingresa tu contraseña");
      status_web("Cargando...");
      datos=$(".popup-detalle-contacto form").serialize();
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          if (res==1) {
            if (msg=="" || msg==null) {
              status_web("Ahora ingresa tu pin ^^");
            } else{
              status_web(msg);
            }
            $(".popup-detalle-contacto input[name='correo']").addClass('animated fadeOutLeftBig').parent().hide();
            $(".popup-detalle-contacto input[type='password']").show().addClass('animated fadeInLeftBig');
            // $(".popup-detalle-contacto input[type='password']").fadeIn();
            $("#login_cliente input[type='button']").attr("onclick", "check_cliente()");
          } else{
            status_web("Se ha enviado tu pin a tu correo electronico ^^");
            check_correo("Se ha enviado tu pin a tu correo electronico ^^");
          }
        }
      });
    }

    function check_cliente(){
      if ($(".popup-detalle-contacto #login_cliente input").val()=="") {
        status_web("Ingresa tus datos ^^");
        return false;
      }

      status_web("Comprobando PIN ...");
      // Origen: 
      $(".popup-detalle-contacto form input[name='origen']").val("check_cliente");
      datos=$(".popup-detalle-contacto form").serialize();
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          
          $("#msg_pop_compra").html("Verifica que tu información sea correcta");
          $(".popup-detalle-contacto form input[name='origen']").val(res);
          if (res=="check_cliente") {
            status_web("Bah ... Intentalo nuevamente ^^");
          } else{
            status_web("^^ Correcto.");
            info_cliente();
          }
        }
      });
    }
    
    function enviar_compra(){
      status_web("Guardando tu compra ...");
      datos=$(".popup-detalle-contacto form#enviar_compra").serialize();
      datos=datos+"&bonoVAL="+bonoVAL+"&bonoCODIGO="+bonoCODIGO;
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        success:function(res){
          
          status_web("Compra finalizada ^^");
          $("#enviar_compra input[name='origen']").val("check_cliente");
          $("#info_compra").fadeOut();
          html="\
          <p><b>Detalle de la compra:</b></p>\
          <p><strong>Producto</strong> <?php echo $title ?></p>\
          <p><strong>Tipo de entrega</strong> Personal</p><strong>Valor total</strong> $"+numberWithCommas(precioTotal)+"\
          <p>* Recordar presentar documento de identidad a la hora de realizar la compra.</p>\
          <p>* El valor del domicilio no esta incluido en la compra.</p>";
          $(".popup-detalle-contacto .nota-2").html(html);
          $(".popup-detalle-contacto .nota-2").addClass('animated tada').show();
          //info_cliente();
        }
      });
    }

    function info_cliente(){
      // Origen: get_informacion_cliente
      status_web("Cargando tu información ...");
      datos=$(".popup-detalle-contacto form").serialize();
      console.log(datos);
      $.ajax({
        url:"/ajax-productos",
        data:datos,
        type:"POST",
        cache: false,
        dataType: "json",
        success:function(res){
          console.log(res);
          ajustarPopupDetalleContacto(500);
          clienteID=res.id;
          $(".popup-detalle-contacto form input[name='nombre']").val(res.nombre);
          $(".popup-detalle-contacto form input[name='apellidos']").val(res.apellidos);
          $(".popup-detalle-contacto form input[name='telefono']").val(res.telefono);
          $(".popup-detalle-contacto form input[name='celular']").val(res.celular);
          $(".popup-detalle-contacto form input[name='cedula']").val(res.cedula);
          $(".popup-detalle-contacto form input[name='direccion']").val(res.direccion);
          $(".popup-detalle-contacto form input[name='puntos']").val(res.puntos);
          $(".popup-detalle-contacto form input[name='origen']").val("enviar_compra");
          console.log(res);
          $("#login_cliente").fadeOut();
          $("#info_cliente").fadeIn();
          status_web("Bienvenido(a) "+res.nombre+" ^^");
        }
      });
    }

    function ajustarPopupDetalleContacto(height, width){
      $(".popup-detalle-contacto").css("height", height+"px");
      height=height-23;
      $(".popup-detalle-contacto .fondo_blanco").css("height", height+"px");
      if (width!="") {
        $(".popup-detalle-contacto").css("width", width+"px");
        width=width-23;
        $(".popup-detalle-contacto .fondo_blanco").css("width", width+"px");
      }
    }
  // Fin compras
</script>


<style>

  /*.close{
  margin-top: -45px;
  font-size: 18px;
  color: #607D8B;
  padding: 5px 11px;
  border: none;
  border-radius: 5px;
  outline: none;
  position: relative;
  height: 35px;
  width: 74px;
    float: right;
  }
  .close:after{
  content: "Cerrar";
  position: absolute;
  margin: -9px 0px 0px -92px;
  font-size: 18px;
  z-index: 2;
  background: #7dbebd;
  color: #fff;
  padding: 5px 9px;
  border: none;
  border-radius: 5px;
  outline: none;
  cursor: pointer;
  font-family: 'Raleway', sans-serif;
  font-weight: 100;
  left: 92px;
  top: 9px;
  }*/
  .popup-detalle-contacto .nota-2{
    display: none;
    text-align: left;
    background: #fadc5a;
    padding: 10px;
    margin: 20px 0px 0px 0;
    border-radius: 5px;
  }
  .popup-detalle-contacto .views-field-field-foto{
  float: left;
  margin-right: 15px;
  }
  .popup{
    animation:0.5s;
    position: fixed;
    top: 52px;
    left: -3px;
    right: 0;
    margin: 0 auto;
    width: 430px;
    height: 150px;
    z-index: 1000;
    padding: 5px;
    box-shadow: 4px 4px 21px -5px rgba(0,0,0,0.75);
    border-radius: 5px;
    background: rgba(83, 95, 109, 0.23);
    color: #1b2c3f;
  }

  .fondo_blanco{
    padding: 10px;
    margin: 0 auto;
    background: #fff;
    height: 148px;
    z-index: -1;
    border: solid 1px #AAB7C5;
    border-radius: 5px;
  }
  .popup-detalle-contacto span{
    display: block;
    margin: 0px 0 8px 60px;
    height: 30px;
  }
  .popup-detalle-contacto .views-field-title-1{
  font-size: 20px;
      padding: 0px 10px 0px;
    text-align: right;
  }
  .popup-detalle-contacto .views-field-field-title-1:after{
  content: "¡Comunicate ya!";
  display: block;
  font-size: 18px;
  }
  .popup-detalle-contacto .views-field-field-telefono a{
  background: url(/files/images/icon-w.png);
  background-repeat: no-repeat;
  padding: 5px 0 10px 38px;
  }
  .popup-detalle-contacto .views-field-field-direccion a{
  background: url(/files/images/icon-map.png);
  background-repeat: no-repeat;
  padding: 5px 0 5px 38px; 
  display: inline-block;
  width: auto;
  }
  .popup-detalle-contacto .views-field-field-facebook a{
  /*color: transparent;*/
  background: url(/files/images/icon-facebook.png);
  background-repeat: no-repeat;
  background-size: 30px 30px;
  padding: 5px 0 7px 38px; 
  background-position: 0px -1px;
  }
  .popup-detalle-contacto .views-field-field-youtube a{
  color: transparent;
  background: url(/files/images/icon-you.png);
  background-repeat: no-repeat;
  padding: 5px 5px 5px 38px;
  background-size: 41px;
  }
  
  #page-wrapper{
    overflow: hidden;
  }
  .messages.error{display: none;}
  .col-der .title-columna{
    margin-top: 0;
  }
	.field-label{display: none;}
	.field-name-field-precio{}
  h1.title{
    margin: 15px 0 20px;
    color: #1b2c3f;
    font-size: 18px;
    margin-left: 30px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .share-twitter{
    margin-bottom: 15px !important;
  }
  html body .container section.col-izq{width: 455px;}
  html body .container section.col-der{width: 514px;}
  .owl-carousel .owl-item img{
    border: solid 1px #AAB7C5;
    padding: 2px;
  }
  .foto-vendedor img{margin-bottom: 10px;}
  .foto-vendedor .views-row{text-align: center;}
  .columna-node-producto .foto-vendedor{vertical-align: top;}
  .columna-node-producto .espacio-accion{margin: 0px 0 0 100px;}
  .view-display-id-block_1 .views-field-title-1 span.field-content {
    font-size: 14px;
    background: rgba(230,143,9,0.5);
    color: #404040;
    padding: 5px 10px;
    display: block;
    border-radius: 5px;
  }
  .view-display-id-block_1 .views-field-title-1 span.field-content:before {
    content: "Un producto de:";
    display: block;
  }
  .popup{
    display: none;
  }
</style>