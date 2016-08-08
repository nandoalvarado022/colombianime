  <?php
    /*Metas de facebook*/
    // echo $title;
    $imagen=$node->field_imagen_principal["und"][0]["uri"];
    $imagen=str_replace("public://", "/sites/default/files/", $imagen);

    $temptitle="Revista Área Caribe - ".$title;
    $og_title = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:title',
    'content' => $temptitle,
    ));
    drupal_add_html_head($og_title, 'og_title');

    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $og_url = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:url',
    'content' => $actual_link,
    ));
    drupal_add_html_head($og_url, 'og_url');

    $element = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:image',
    'content' => $imagen,
    ));
    drupal_add_html_head($element, 'og_image');

    //print_r($node->body->["und"][0]["value"]);
    $description=$node->body["und"][0]["value"];
    $description=substr($description, 0, 300);
    $description=$description."...";
    $og_description = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:description',
    'content' => $description,
    ));
    drupal_add_html_head($og_description, 'og_description');
  ?>
  <link rel="stylesheet" href="http://stage.elheraldo.co/sites/default/themes/eh/especiales/area-caribe.css">
  <div class="slider-block">
    <?php print render($content['highlighted']); ?>

    <?php // print render($page['header']); ?>
    <?php $slug=str_replace(" ", "-", $title);?>
    <div class="infoGaleria">
      <div class="info">
        <div class="url">
          <div style="display:none;">
            <?php
              $variablesAll=get_defined_vars();
              $nombreEmpresa=$variablesAll["field_empresa"][0]["taxonomy_term"]->name;
              $nombreEmpresa=str_replace(" ", "-", $nombreEmpresa);
              $correoContacto = $node->field_correo_de_contacto;
              $emailEmpresa = $variablesAll["field_empresa"][0]["taxonomy_term"]->field_correo_de_contacto;//$node->field_empresa->format;
              $correo = $correoContacto['und'][0]['value'];
              $correoEmpresa = $emailEmpresa['und'][0]['value'];
              if($correo != "" and $correoEmpresa != ""){
                $destino = $correo.", ".$correoEmpresa;
              }
              elseif ($correo != "" and $correoEmpresa == ""){
                $destino = $correo;
              }
              elseif ($correo == "" and $correoEmpresa != ""){
                $destino = $correoEmpresa;
              }
            ?>
          </div>
          <a href="/#proyectos">Proyectos</a> &nbsp; >
          <?php
          $nombre_empresa=$node->field_empresa["und"][0]["taxonomy_term"]->name;
          $id=$node->field_empresa["und"][0]["taxonomy_term"]->tid;
          $link=drupal_get_path_alias('taxonomy/term/'.$id);
          ?>
          <a href="/<?php echo $link;?>">
          <?php echo $nombre_empresa;?></a> &nbsp; >
          <a style="color: #FFF;">&nbsp;<?php echo $title?></a>
        </div>
        <!-- <div class="logo">
          <img src="../sites/default/files/<?php echo $variablesAll["field_empresa"][0]["taxonomy_term"]->field_logo["und"][0]["filename"]?>" />
        </div> -->
        <h1 class="nombre"><?php echo $title;?></h1>
      </div>

      <?php
      foreach ($field_imagen_principal as $key => $value) {
        /*
        echo "<br>";
        echo image_style_url('1000x560', $filename);
        echo "<br>";
        echo image_style_path('1000x560', $filename);
        echo "<br>";
        */
      }
      ?>
      <section id="slider">
        <div id="demo" class="box-slide">
          <div class="container">
            <div class="row">
              <div class="span12">
                <div id="owl-demo" class="owl-carousel owl-img-proyectos">
                  <?php
                    foreach ($field_imagen_principal as $key => $value) {
                      $key++;
                      $valor=$valor-1000;
                      echo "<div class='item'>";
                      $filename=file_build_uri($value["filename"]);
                      $src=image_style_url('1000x560', $filename);
                      echo "<img data-left='".$valor."' rel='".$key."' src='".$src."'>";
                      echo "</div>";
                    }?>                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div><!--back-container-->
  <div id="main-home">
    <div class="content">
      <!--
      <div class="slide-imagenes-proyecto">
        <?php /*
        $valor=1000;
        foreach ($field_imagen_principal as $key => $value) {
          $key++;
          $valor=$valor-1000;
          echo "<img data-left='".$valor."' rel='".$key."' src='../sites/default/files/".$value["filename"]."'>";
        }*/
        ?>
      </div>-->
      <div class="descripcion">
        <div>
          <h3>Descripción
            <div class="redes-sociales">
            <?php include("social_buttons_new.tpl.php"); ?>
            </div>
          </h3>
        </div>
        <p>
          <?php
            echo $body[0]["value"];
          ?>
        </p>
      </div>

      <div class="detalle">
        <p>
          <label>Desde</label>
          <span><?php echo "$".number_format($field_apartamentos_desde[0]["value"]);?></span>
        </p>
        <p>
          <label>Tipo de desarrollo</label>
          <span><?php echo $field_tipo_de_desarrollo[0]["value"];?></span>
        </p>
        <p>
          <label>Entrega</label>
          <span><?php echo $field_fecha_entrega[0]["value"];?></span>
        </p>
        <p>
          <label>Apartamentos</label>
          <span><?php echo $field_numero_de_apartamentos[0]["value"];?></span>
        </p>
        <p>
          <label>Barrio</label>
          <span><?php echo $field_barrio[0]["value"];?></span>
        </p>
         <p>
          <label>Dirección</label>
          <span><?php echo $field_direccion[0]["value"];?></span>
        </p>
        <p>
          <label>Habitaciones</label>
          <span><?php echo $field_numero_de_habitaciones[0]["value"];?></span>
        </p>
        <p>
          <label>Garaje</label>
          <span><?php echo $field_garaje[0]["value"];?></span>
        </p>
        <p>
          <label>Baños</label>
          <span><?php echo $field_numero_de_banos[0]["value"];?></span>
        </p>
        <p>
          <label>Tipo de inmueble</label>
          <span><?php echo $field_tipo_de_inmueble[0]["taxonomy_term"]->name;?></span>
        </p>
       

      </div>

      <div class="detalleDos">
        <div class="multimedia">
            <h3>Generales</h3>
          <?php
            if ($field_logo[0]["filename"]!="") {
              //echo "<img src='../sites/default/files/".$field_imagen_principal[0]["filename"]."'>";
              echo "<img src='../sites/default/files/".$field_logo[0]["filename"]."'>";
            }
          ?>
            <p class="descripcion">
              <?php echo $field_generales[0]["value"];?>
            </p>
        </div>
        <div class="datos">
            <h3>Un proyecto de:</h3>
          <?php $view = views_get_view('frontpage'); print $view->preview('block_7');?>
        </div>
      </div>
      <div class="detalleTres">
        <div class="calculaCredito">
          <span class="titulo">
            <span class="icon">
            </span>
            Calcula tu crédito
          </span>
          <p>
            <span class="ingresos">Ingresos personales mensuales</span>
          </p>
          <p>
            <span>Tipo de inmueble</span>
            <select>
              <option>Seleccione</option>
            </select>
          </p>
          <p>
            <span>Plazo de credito (en años)</span>
            <select>
              <option>Seleccione</option>
            </select>
          </p>
          <button>Calcular</button>
        </div>
        <div class="contactanos">
          <form name="form-01" method="POST">
            <input type="hidden" name="email_cc" value="gestion.digital@elheraldo.co, adriana.marin@elheraldo.co, grace.sierra@elheraldo.co, virginia.montes@elheraldo.co">
            <input type="hidden" name="email_to" value="<?php echo $destino; ?>">
            <input type="hidden" name="proyecto" value="<?php echo $title; ?>">
            <input type="hidden" name="empresa" value="<?php echo $nombreEmpresa; ?>">
            <span class="titulo">Contactanos</span>
            <?php
              $path = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            ?>
            <p>
              <input type="hidden" value="<?php echo $path?>" name="link_proyecto">
              <input type="text" placeholder="Nombre" name="nombre">
            </p>
            <p>
              <input type="text" placeholder="Teléfono" name="telefono">
            </p>
            <p>
              <input type="text" placeholder="Correo" name="correo">
            </p>
            <p>
              <textarea type="text" name="mensaje" style="height: 60px;" placeholder="Mensaje..."></textarea>
            </p>
            <p class="p_term_condic">
              <input type="checkbox">
              <span class="term_condic">
                <a href="/terminos-y-condiciones" target="_BLANK">Acepto los términos y condiciones</a>
              </span>
            </p>
          </form>
          <button onclick="enviar_datos()">Enviar</button>
        </div>
      </div>
    </div>
  </div><!-- main home-->

  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300);
    @import url(https://fonts.googleapis.com/css?family=Jaldi:400,700);
    #main-home{width: 100%; margin: 0 auto;}
    #main-home .content{width: 980px; margin: 0 auto;padding-bottom: 30px;}
    #main-home .content .detalle {padding: 0 2%;border-right: solid 1px #ccc;margin: 30px 0;text-align: center;width: 24%;float: left;}
    #main-home .content .detalle p {display: inline-block;width: 94%;border-bottom: 1px solid #ccc;text-align: left;margin: 0 0 20px;}
    #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(8), #main-home .content .detalle p:nth-child(9) {width: 45%;display: block;float: left;}
    #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(9) {margin: 0 4% 20px 7px;}
    #main-home .content .detalle p:last-child{border: none;margin: 0;}
    #main-home .content .detalle p span {color: #19476F;font-weight: 600;}
    #main-home .content .detalle p label{color: #9E9E9E; font-weight: 500;}
    #main-home .content > .descripcion {width: 65%;min-height: 600px;float: left;margin: 30px 0;border: 1px solid #ccc;border-top: 0;border-bottom: 0;padding: 0 3%;position: relative;}
    #main-home .content > .descripcion:after {content: " ";width: 973px;display: block;border-bottom: 1px solid #ccc;position: absolute;bottom: -30px;margin: 0 -30px;}
    #main-home .content > .descripcion h3 {color: #049ED4;font-size: 2em;border-bottom: solid 1px #ccc;margin: 0 0 10px;padding: 0 0 10px;}
    #main-home .content > .descripcion .redes-sociales .social-sharing a{background: none; color: transparent; width: 34px;}
    #main-home .content > .descripcion p {color: #666;font-size: 1.1em;font-weight: 100;margin: 0;}
      
    #main-home .content .detalleDos{width: 100%; margin: 30px 0; display: inline-block; overflow: hidden;}
    #main-home .content .detalleDos .multimedia {width: 46%;min-height: 400px;padding: 0 2%;border-left: 1px solid #ccc;border-right: 1px solid #ccc;float: left;}
    #main-home .content .detalleDos .datos {width: 45%;padding: 0 2%;border-right: 1px solid #ccc;float: left;min-height: 400px;}
    #main-home .content .detalleDos .datos .views-field-field-logo {width: 80%;margin: 10px auto 30px;}
    #main-home .content .detalleDos .datos .views-field-field-logo img {width: 100%;}
    #main-home .content .detalleDos .datos p {display: block;width: 100%;background: #112B3A;margin: 10px auto;border-radius: 3px;padding: 10px 0;text-align: center;}
    #main-home .content .detalleDos .datos p span{display:inline-block;font-size: 16px;color: #FFF;font-weight: 500;}
    #main-home .content .detalleDos .datos p span a {color: #FFF;}
    #main-home .content .detalleDos .datos p span.title{color: #C3C3C3;font-weight: 400;}
    #main-home .content .detalleDos .multimedia img{max-width:100%;}
    #main-home .content .detalleDos .multimedia h3, #main-home .content .detalleDos .datos h3 {font-size: 21px;color: #FFF;background: #048ABF;padding: 8px 0;margin: 0 auto 10px;width: 400px;text-align: center;border-radius: 4px;}
    #main-home .content .detalleDos .multimedia .descripcion {width: 90%;margin: 0 auto;color: #666;text-align: justify;line-height: 1.4em;font-size: 1.1em;font-weight: 100;}
    #main-home .content .detalleDos .detalleTres {display: block;vertical-align: top;margin: 30px auto 0;width: 90%;}
    #main-home .content .calculaCredito{width: 400px;
    margin: 40px 0 0 30px;
    display: none;
    border: solid 1px #ccc;
    vertical-align: top;
    padding: 20px;}
    #main-home .content .calculaCredito .titulo{color:#0171BD;font: 34px "Dosis",sans-serif;}
    #main-home .content .calculaCredito .titulo .icon{background-image: url(../img/calc.png);width: 47px;height: 47px;display: inline-block;}
    #main-home .content .calculaCredito button{background: #F7921E;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 15px;}
    #main-home .content .calculaCredito p span{color:#B1B1B1;display: block;}
    #main-home .content .calculaCredito p span.ingresos{color:#B1B1B1; font-weight:bold;}
    #navigation{display: none;}
    #site-name{display: none;}
    #breadcrumb{display: none;}
    .messages{display: none;}
    .body.sidebar-first #main{float: none !important;}
    
    .detalleTres {border-left: 1px solid #ccc;border-right: 1px solid #ccc;width: 99%;padding: 20px 0;margin: 30px 0 0;position: relative;}
    .detalleTres:before {content: " ";width: 973px;display: block;border-bottom: 1px solid #ccc;position: absolute;top: -33px;margin: 0;}
    #main-home .content .contactanos {width: 80%;height: 315px;margin: 0 auto;background-color: #FFFFFF;text-align: center;border-radius: 4px;border: 1px solid #ccc;box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);}
    #main-home .content .contactanos .titulo {background: #112B3A;color: #fff;width: auto;display: block;padding: 5px 30px 5px 50px;margin: 30px 400px 20px -20px;border-radius: 0 20px 20px;position: relative;float: left;font-size: 24px;}
    #main-home .content .contactanos .titulo:before {content: " ";position: absolute;left: 0;top: -20px;width: 0;height: 0;border-style: solid;border-width: 0 0 20px 20px;border-color: transparent transparent #069 transparent;}
    #main-home .content .contactanos p {margin: 0 0 10px 0;display: block;float: left;width: 50%;}
    #main-home .content .contactanos input[type="text"], #main-home .content .contactanos textarea {padding: 10px 10px 10px 10px;border: rgba(204, 204, 204, 0.68) solid 1px;margin: 0px 20px;width: 80%;color: #4C4C4C;font-size: 14px;border-radius: 4px;}
    #main-home .content .contactanos .term_condic{text-decoration: underline;font-size: 13px;}
    #main-home .content .contactanos .p_term_condic{text-align:left;padding-left:34px;}
    #main-home .content .contactanos button {background: #048ABF;color: #fff;border: none;padding: 10px 20px;font-size: 15px;float: right; margin: 0 30px;text-transform: uppercase;letter-spacing: 5px;border-radius: 4px;box-shadow: 0 3px 0 #333;cursor: pointer;}
      #main-home .content .contactanos button:hover{background: #112B3A;}
    /*Slide images proyecto*/
    #slider{/*height: 570px;/* overflow: hidden;*/}
    #slider .contenedor{width: 50000px;position: absolute;transition: all 0.4s ease-in-out;left: 0px;}
    #slider .contenedor img{width: 1000px;height:570px; display: inline-block;}

    .slide-imagenes-proyecto{text-align: center;padding-top:60px;}
    .slide-imagenes-proyecto img{width:90px;height:auto;min-height:70px;margin: 0 4px 0;    background-color: #000;filter: alpha(opacity=45);opacity: .45;transition: opacity .6s;-moz-transition: opacity .6s;-webkit-transition: opacity .6s;-o-transition: opacity .6s; cursor: pointer; max-height: 70px;}
    .slider-block .infoGaleria{background: #fff;/*overflow: hidden;*/width:1000px;position: relative;/*height: 590px;*/}
    .slider-block .infoGaleria .owl-item img {width: 100%;}
    .slider-block .infoGaleria .info{overflow: hidden;font-size: 14px;}
    .slider-block .infoGaleria .info .logo{right: 10px;position: absolute;top: 10px;}
    .slider-block .infoGaleria .info .logo img{max-width:150px;}
    .slider-block .infoGaleria .info .url{display: inline-block;color: #C3C3C3;margin: 20px 0 10px 10px;font-size: 15px;}
    .slider-block .infoGaleria .info .url a {color:#C3C3C3;}
    .slider-block .infoGaleria #slider{float:none;width: 970px;margin: 15px auto;position: relative;/*height: 504px;*/}
    #sidebar-first{display: none;}
    .selected{border-bottom: 5px solid #09709B;height:65px !important;min-height: 0px !important;opacity: 1 !important;}
    .ver-mas, .ver-mas-dos{display: none;}

    @media screen and (max-width: 1100px){
        .slider-block {width: 94%;}
        .slider-block .infoGaleria { width: 100%;}
        .slider-block .infoGaleria #slider {width: 96%;}
        #main-home .content {width: 94%;}
    }

    @media screen and (max-width: 780px){
        .slider-block .infoGaleria #slider{width: 100%;}
        .slider-block .infoGaleria{width: 100%;}
        #main-home .content{width: 100%;}
        #main-home .content .descripcion {width: 60%;display: block;margin: 0 0 0 3%;}
        #main-home .content .detalle {padding: 0 3%;margin: 0 3% 0 0;width: 21.5%;}
        #main-home .content .detalle p{width: 100%;}
        #main-home .content .detalleDos {width: 94%;margin: 60px 3% 30px;}
        #main-home .content .detalleDos .multimedia h3, #main-home .content .detalleDos .datos h3 {width: 90%;}
        #main-home .content .detalleDos .multimedia {width: 46%;min-height: 370px;}
        #main-home .content .detalleDos .datos {min-height: 370px;}
        .detalleTres { width: 94%;margin: 30px 3% 0;}
        #main-home .content .contactanos {width: 94%;margin: 0 3%;}
        #main-home .content .contactanos .titulo {width: 38%;text-align: left;}
        #main-home .content .contactanos button {margin: 0 3%;}
        .views-field-field-logo img{width: 100%; height: auto;}
        /*.owl-theme .owl-controls{position: absolute; top: 20px; left: 20px;}*/
    }
    @media screen and (max-width: 700px){
        .back-container{background: #FFF}
        .slider-block {width: 100%;}
        #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(8), #main-home .content .detalle p:nth-child(9) {width: 94%;display: inline-block; margin: 0 0 20px 0;}
        #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(9) {margin: 0 10% 20px 0px;}
    }
    @media screen and (max-width: 599px){
        #main-home .content .descripcion {width: 88%;}
        #main-home .content .detalle {margin: 60px 3% 0;width: 88%;border-left: 1px solid #ccc;}
        #main-home .content .detalle p, #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(8), #main-home .content .detalle p:nth-child(9), #main-home .content .detalle p:last-child {width: 46%;display: block;float: left;margin: 0 2%;}
    }
    @media screen and (max-width: 480px){
        .slider-block .infoGaleria #slider{margin: 2px 0; width: 100%; padding: 0;}
        .slider-block .infoGaleria .info .logo{display: none;}
        .slider-block .infoGaleria .info .nombre {width: 100%;padding: 10px 0;margin: 0;border-radius: 0;}
        #slider .owl-theme .owl-controls {margin: 0;}
        .not-front #main-home {box-shadow: inherit;}
        #main-home .content .descripcion {width: 84%;margin: 0 8% 30px;padding: 0;border: 0;}
        #main-home .content .detalle {padding: 0;margin: 30px 8% 60px;width: 84%;position: relative;border-left: 0;}
        #main-home .content .detalle p, #main-home .content .detalle p:nth-child(7), #main-home .content .detalle p:nth-child(8), #main-home .content .detalle p:nth-child(9), #main-home .content .detalle p:last-child {width: 38%;margin: 0 1.5% 7px 0;padding: 10px 5%;float: left;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;}
        #main-home .content .detalle:after {content: " ";width: 118%;display: block;border-bottom: 1px solid #ccc;position: absolute;bottom: -30px;margin: 0 -30px;}
        .detalleTres{width:100%;}
        #main-home .content .detalleDos{display: block; width: 84%; margin: 0 auto;}
        #main-home .content .detalleDos .multimedia {width: 100%;min-height: inherit;padding: 0 0 20px;margin: 0 0 25px;border-left: 0;border-bottom: 1px solid #ccc;}
        #main-home .content .detalleDos .multimedia img{height: auto; max-width: 100%;}
        #main-home .content .detalleDos .multimedia h3, #main-home .content .detalleDos .datos h3 {width: 60%;}
        #main-home .content .detalleDos .multimedia .descripcion {width: 100%;margin: 20px auto 0;}
        #main-home .content .detalleDos .datos {min-height: inherit;width: 100%;padding: 0 0 25px;}
        #main-home .content .detalleDos .datos .views-field-field-logo img{width: 100%; height: auto;}
        .detalleTres:before {width: 118%;top: 0;}
        .detalleTres {margin: 0;}
        #main-home .content .contactanos {width: 84%;margin: 15px auto;height: 445px;}
        #main-home .content .contactanos p {width: 100%;}
        #main-home .content .contactanos button {margin: 0 auto;float: none;}
        body .logo-areacaribe {
        display: inline-block;
        margin: 0 auto;
        width: 240px;
        }
       body #footer span{
        text-align: center;
        margin: 0 auto;
        width: 100%;
        margin-top: 10px;
      }
      body .redes-footer, body .logo-heraldo{
        display: none;
      }
      .menu-mobile{
        display: block;
      }
      body .view-display-id-block_14 .view-content{
      width: 100%;
      }
      body .view-display-id-block_14 .views-row{
        width: 94%;
        float: none;
        text-align: center;
        margin-right: 0px;
      }
      body .view-display-id-block_14 .views-row .descripcion p{
      text-align: center;
      }
      body .view-display-id-block_14{
      width: 100%;
      padding: 0px;
      height: 1015px;
      overflow: hidden;
      position: relative;
      margin-bottom: 20px;
      transition: all 0.9s ease-in-out;
      -webkit-transition: all 0.9s ease-in-out;
      -moz-transition: all 0.9s ease-in-out;
      -o-transition: all 0.9s ease-in-out;
      -ms-transition: all 0.9s ease-in-out;
      }
      body .te-quedaste-corto{
      width: 90%;
      }
      body .paginadores-corto{
        display: none;
      }
      body ul.menu-feria li{
        width: 33%;
        border-right: medium none;
        height: 26px;
        padding-top: 5px;
        display: none;
      }
      body ul.menu-feria{
       width: 100%;
        border: none;
        top: 20px;
        background-color: transparent;
        margin-top: 10px;
        position: inherit;
      }
      body ul.menu-feria li:last-child{
        display: none;
      }
      body ul.menu-feria li:nth-child(3){
        border-bottom: none;
      }
       body ul.menu-feria{
        width: 100%;
        border: none;
        top: 20px;
      }
      .slider-block{width:auto;}
      .logo-feria{width: 300px;background-size: 100%;margin: 0 auto;display: block;}
      .redes-sociales{float:none;display: block;text-align: center;}
      .section-logos{height: 140px;}
      .slider-block .infoGaleria{width:auto}
      .slider-block .infoGaleria .info .logo{position:relative;text-align: center;}
      .slider-block .infoGaleria .info .logo img{max-width: 190px;}
      .slider-block .infoGaleria{height:auto}
      .back-container {height: auto;}
      #main-home .content .calculaCredito{margin: 40px 0 0 0px;width: auto;}
      #main-home .content .calculaCredito button{border-radius: 6px;}
      #main-home .content .contactanos input[type="text"], #main-home .content .contactanos textarea{width:260px;}
      .te-quedaste-corto{width:auto;}
      .box-tittle{width:auto;}
      .view-display-id-block_14{width:auto}
      .view-display-id-block_14 .view-content{width: 5000px;text-align: center;}
      .view-display-id-block_14{padding: 0px 0px;}
      .detalleTres{float: none;display: block;}
      #slider .contenedor{width: auto;}
      body.sidebar-first #main{width: 100%;overflow: hidden;display: block;margin: 0 auto;}
      #main-home{width: 320px;margin: 0 auto;overflow: hidden;}
      .slide-imagenes-proyecto img{max-width: 320px; width: auto;}
      .slide-imagenes-proyecto{display: none;}
      .back-container-two{padding: 10px 0px;margin-top: 20px;}
      body .redes-sociales{
        float: none;
        display: inline-block;
        position: initial; ;
        text-align: center;
        margin: 0 auto;
        width: 100%;
        margin: 20px 0px;
      }
      body .paginadores{
        display: none;
      }
      .detalleTres{margin-left:0px;}
      #footer .contenedor{width: auto;}
      #footer .logoFooter{
        height: 85px;
        width: 236px;
        margin: 0 auto;
      }
      #main-home .content .contactanos .titulo{width: auto;}
    }
    @media screen and (max-width: 350px){
        #main-home .content .detalle p label {font-size: 14px;}
        #main-home .content .contactanos input[type="text"], #main-home .content .contactanos textarea { width: 75%;}
        #main-home .content .detalle p{width: 88%;margin: 0 1.5% 7px 0;padding: 10px 5%;float: left;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;}
        #main-home .content > .descripcion p {font-size: 1em;}
    }
  </style>
</div> <!-- /#container -->

<?php
$q_ori=$_GET["q"];
$empresa_cod=$node->field_empresa["und"][0]["tid"];
$_GET["q"]="taxonomy/term/".$empresa_cod;
?>

<div class="back-container-two">
  <div class="te-quedaste-corto">
    <div class="box-tittle"><h2 style="width:250px;">Otros Proyectos</h2></div>
    <div class="sombra-title"></div>
    <div class="contenedor">
      <div id="demo">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div id="owl-demo" class="owl-carousel owl-tequedastecorto">
                <?php //$currentterm = "";
                print $view_content = views_embed_view("frontpage", "block_14", $empresa_cod, $node->vid);
                //$view = views_get_view('frontpage'); print $view->preview('block_14'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$_GET["q"]=$q_ori;
?>

<script>
  $(document).ready(function(){
    temp=$(".view-frontpage.view-display-id-block_14 div");
    if (temp.length==0) {
      $(".back-container-two").hide();
    }
  });

  function cargaSlider_tequedastecorto(){
    html=$(".view-frontpage.view-display-id-block_14 .view-content").html();
    $("#demo #owl-demo.owl-tequedastecorto").html(html).promise().done(function(){
      $("#owl-demo.owl-tequedastecorto").owlCarousel({
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        //singleItem:true,
        // "singleItem:true" is a shortcut for:
        items : 1,
        itemsDesktop : [981800, 4],
        itemsDesktopSmall : [900, 3],
        itemsTablet: [600, 2],
        itemsMobile : [480, 1]
      });
    });

    /*Cambiar tamaño slider inferior*/
    size=$(".te-quedaste-corto .owl-item").size();
    switch(size){
      case 1:
        $(".te-quedaste-corto .owl-wrapper").css("width", "250px");
      break;
      case 2:
        $(".te-quedaste-corto .owl-wrapper").css("width", "500px");
      break;
      case 3:
        $(".te-quedaste-corto .owl-wrapper").css("width", "750px");
      break;
    }
  }

  function cargaSlider(){
    //html=$(".view-frontpage.view-display-id-block_13 .view-content").html();
    //$("#demo #owl-demo.owl-principal").html(html).promise().done(function(){
      
      $("#owl-demo.owl-img-proyectos").owlCarousel({
        autoPlay: true,
        navigation : true,
        navigationText : ["<",">"],
        slideSpeed : 400,
        paginationSpeed : 2000,
        items : 1,
        itemsDesktop : [1199,1],
        itemsDesktopSmall : [899,1],
        itemsTablet: [799,1],
        itemsMobile : [749,1]        
      });
  //});
  }

  var x = 0;
  $(function() {
    cargaSlider();
    cargaSlider_tequedastecorto();
    

    /*Selected al primer hijo de slider*/
      $(".slide-imagenes-proyecto [rel='1']").addClass("selected");
    var x = 0;
    $(".paginadores-corto .pag-corto-right").click(function(){
      x = parseInt(x) - 950;     
      var xx = x + "px";      
      if ( ( x < -2850 ) ){        
        $(".view-display-id-block_14 .view-content").css("left","0");
        x = 0
      }else{
        $(".view-display-id-block_14 .view-content").css("left",xx);
      }
    });

    $(".paginadores-corto .pag-corto-left").click(function(){
      x = parseInt(x) + 950;      
      var xx = x + "px";     
      if ( ( x > 0 ) ){        
        $(".view-display-id-block_14 .view-content").css("left","-2850px");
        x = -2850
      }else{
        $(".view-display-id-block_14 .view-content").css("left",xx);
      }
    });

    $(".view-display-id-block_14 .views-row").mouseover(function(){
    $(this).find(".info_especial").css({opacity:"1"});
    });
    $(".view-display-id-block_14 .views-row").mouseleave(function(){
    $(this).find(".info_especial").css({opacity:"0"});
    });

    /*Slider*/
    for (var i = 2; i < 100; i++) {
      $(".datos .views-row-"+i).hide();
    };
  });

  function enviar_datos(){
    datos=$("[name=form-01]").serialize();
    console.log(datos);
    $.ajax({
      url:"../ajax/contactanos.php",
      data:datos,
      type:"POST",
      success:function(res){
        alert(res);
        $("[name=form-01]").reset();
      }
    });
  }
</script>