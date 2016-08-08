  <?php
  $og_title = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:title',
  'content' => "Area Caribe",
  ));
  drupal_add_html_head($og_title, 'og_title');

  $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
  $og_url = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:url',
  'content' => "http://areacaribe.calipso.com.co",
  ));
  drupal_add_html_head($og_url, 'og_url');

  $element = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:image',
  'content' => "http://areacaribe.calipso.com.co/themes/framework/images/logo-area-caribe-bg-azul-cuadra.png",
  ));
  drupal_add_html_head($element, 'og_image');

  $og_description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:description',
  'content' => "Encuentre casas, apartamentos, oficinas, bodegas, fincas y m&#xe1;s inmuebles en venta y arriendo. Areacaribe.com.co el sitio web para vender su inmueble.",
  ));
  drupal_add_html_head($og_description, 'og_description');?>
	<div class="slider-block">
		<?php $slug=str_replace(" ", "-", $title);?>
		<div class="encabezado">
			<div class="info">
			<!--<div class="url">
			<a href="http://especiales.elheraldo.co/feriainmobiliaria">Feria inmobiliaria</a> / 
			<a href="http://especiales.elheraldo.co/feriainmobiliaria/content/<?php echo $slug?>"><?php echo $title?></a>
			</div>-->
			</div>
      <div class="content">
        <?php $view = views_get_view('general_tipos_contenido'); print $view->preview('block_1'); ?>
        <?php $view = views_get_view('general_tipos_contenido'); print $view->preview('block'); ?>
          <div class="box-tittle"><h2>Más Noticias</h2></div>
        <?php $view = views_get_view('general_tipos_contenido'); print $view->preview('block_2'); ?>
      </div>
		</div>
	</div>
</div><!-- back-container-->

<div class="back-container-two">
  <div class="te-quedaste-corto">
    <div class="box-tittle"><h2 style="width:250px;">Te puede interesar</h2></div>
    <div class="sombra-title"></div>
    <div class="contenedor">
      <div id="demo">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div id="owl-demo" class="owl-carousel owl-tequedastecorto">
                <?php $currentterm = "";
                $view = views_get_view('frontpage'); print $view->preview('block_4'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--
      <div class="ver-mas-dos">Ver más</div>
      <div class="paginadores-corto">
        <div class="pag-corto-left"></div>
        <div class="pag-corto-right"></div>
      </div>-->
    </div>
  </div>
</div>

<script>
  $(function() {
    cargaSlider_tequedastecorto();

    for (var i = 2; i < 100; i++) {
      $(".datos .views-row-"+i).hide();
    };
  });

  function cargaSlider_tequedastecorto(){
    html=$(".view-frontpage.view-display-id-block_4 .view-content").html();
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
  }
</script>

<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300);
  @import url(https://fonts.googleapis.com/css?family=Jaldi:400,700);
  .view-id-general_tipos_contenido {
  display: inline-block;
  margin-top: 20px;
  }
  .view-display-id-block_2 {
  padding: 0px 20px 40px;
  }
  .view-display-id-block_2 .views-row-1, .view-display-id-block_2 .views-row-2, .view-display-id-block_2 .views-row-3 {
      margin-right: 20px;
  }
  .view-display-id-block_2 .views-row {
  width: 224px;
  float: left;
  background-color: rgba(204, 204, 204, 0.1);
  overflow: hidden;
  }
  .encabezado .content{
    min-height: 800px;
  }
  .encabezado .content .view-display-id-block .view-content .views-row{
    display:block;
    text-align: left;
    position: relative;
    font-family: "Dosis",sans-serif;
    width: 310px;
    background-color: rgba(204, 204, 204, 0.22);
    overflow: hidden;
  }
  .encabezado .content .view-display-id-block .view-content .views-row div:first-child {
    width: 310px;
    height: 212px
  }
  .encabezado .content .view-display-id-block .view-content .views-row-1,.encabezado .content .view-display-id-block .view-content .views-row-4{
    margin-left: 25px;
  }
  h2.titulo-proyectos {
    margin: 0px;
    background: transparent linear-gradient(to bottom, #FFF 0%, #F6F6F6 100%) repeat scroll 0% 0%;
  }
  .content .view-display-id-block_1 .views-row{
      width: 626px;
      margin-right: 0px;
      padding-bottom: 0px;
      height: 444px;
      position: relative;
      float: left;
  }
  .fecha_entrega, .fecha_entrega_label {
    font-family: "Dosis", sans-serif;
    color: #29ABE2;
    background-color: rgba(204, 204, 204, 0.13);
    padding: 12px 15px 15px 15px;
    width: 270px;
    display: inline-block;
  } 
  .view-display-id-block_1 .views-row h2.titulo {
      position: absolute;
      top: 320px;
      background-color: rgba(255,253,253,0.85);
      padding: 10px 2.5%;
      left: 0px;
      width: auto;
  }
  .view-display-id-block_1 .views-row h2.titulo a {
      font-size: 21px;
  }
  .view-display-id-block_1 .views-row .views-field-field-sumario {
      position: absolute;
      top: 384px;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 10px 2.5%;
      height: 40px;
      left: 0px;
  }
  .view-display-id-block_1 .views-row .views-field-field-sumario .field-content {
      font-size: 16px;
      line-height: 1.3em;
      font-weight: 500;
      color: #565656;
  }
  .content .view-display-id-block_1{
    width: 626px;
    float: left;
    margin-top: 0px;
    position: relative;
    background-color: #fff;
    padding: 20px;
    height: inherit;

  }
  .encabezado .content .view-display-id-block .view-content .views-row-1{
    margin-left: 0px;
    margin-bottom: 20px
  }
  .view-id-general_tipos_contenido .views-field-field-sumario .field-content{
    color: #808080;
  }
  .view-display-id-block .views-row h2.titulo{
    position: absolute;
    bottom: 0px;
    background-color: rgba(255,253,253,0.85);
    margin-top: 0px;
    -webkit-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -moz-transition: all 0.4s ease-in-out;
    -ms-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    left: 0px;
  }
  .view-id-general_tipos_contenido .views-field-created{
    font-size: 13px;
  }
  .view-display-id-block .views-field-field-sumario{
    display: none;
  }
  .view-id-general_tipos_contenido{
    display: inline-block;
    margin-top: 20px;
  }
  .view-id-general_tipos_contenido .views-field-field-sumario,.view-id-general_tipos_contenido .views-field-created{
    padding: 0px 10px 10px 10px;
  }
  .encabezado .content .titulo{
    width: 94%;
    padding: 10px 0px;
    display: inline-block;
    color: #0073dc;
    font-family: "Dosis", sans-serif;
    margin-top: -2px;
    text-align: left;
    padding: 10px;
  }
  .encabezado .content .titulo a{
    font-size: 16px;
    color: #069;
    font-weight:  bold;
    text-transform:  uppercase;
  }
  .encabezado .content .titulo a:hover{
    color: #049ed4;
  }
  
  .view-display-id-block_2 .views-row a img{
    display:block!important;
    -webkit-transition:-webkit-transform 1s ease-out;
    -moz-transition:-moz-transform 1s ease-out;
    -o-transition:-o-transform 1s ease-out;
    -ms-transition:-ms-transform 1s ease-out;
    transition:transform 1s ease-out;
  }/*
  .view-display-id-block_2 .views-row a img:hover{
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    -o-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1)
  }*/

  .encabezado .content .sumario{
  font-family: "Dosis", sans-serif;
  text-transform: uppercase;
  padding: 10px 2px;
  border-bottom: 1px solid #e6e6e6;
  }
  .encabezado .info .url a{color: #666;}
  .encabezado .info .nombre {color: #0077AC;font-size: 30px;margin: 0 0 0 10px;text-align: center;}
  .encabezado .info {overflow: hidden;font: 15px/20px "Helvetica Neue", Helvetica, Arial, sans-serif;}
  .encabezado .info .url {display: inline-block;color: #666;margin: 20px 0 10px 20px;font-size: 17px;}
  .encabezado .info .nombre {color: #0077AC;font-size: 30px;margin: 0 0 0 10px;}
  #main-home .content{width:1000px;margin: 0 auto;height: 100px;}
  #main-home{width: 100%; margin: 0 auto;}
  h1.title{display: none;}
  #breadcrumb{display: none;}
  .messages{display: none;}
  .body.sidebar-first #main{float: none !important;}
  #sidebar-first{display: none;}
  .slider-block .encabezado{width: 1000px;height:auto;}
  .view-id-general_tipos_contenido.view-display-id-block{background: #fff; margin: 0; height: 464px; padding: 20px 0 0; width: 334px;position:relative;}
  .view-id-general_tipos_contenido.view-display-id-block_2{margin: 30px auto 0; display: block;padding: 0px 20px 40px;}
  .view-id-general_tipos_contenido .views-field-field-sumario{padding: 0;}
  .view-id-general_tipos_contenido.view-display-id-block_2 .titulo{padding: 20px 0 10px;}
  .view-id-general_tipos_contenido.view-display-id-block_2 .view-content .views-row  {
  margin-right:  0;
  padding:  25px 25px;
  display:  inline-block;
  vertical-align:  top;
  width:  225px;
  margin:  0 22px 20px;
  }
  .view-id-general_tipos_contenido .views-field-field-sumario .field-content{color: #353535;}
  @media screen and (max-width: 780px){
    .content .view-display-id-block_1 .views-row img{display: block; margin: 0 auto;}
    .view-display-id-block_1 .view-content{width: 100%;}
    .view-id-general_tipos_contenido.view-display-id-block_2 .view-content .views-row{margin-bottom: 20px;}
    .slider-block .encabezado{width: 90%; margin: 0 auto;}
    .encabezado .content .view-display-id-block .view-content .views-row-1, .encabezado .content .view-display-id-block .view-content .views-row{display: inline-block; vertical-align: top; margin-left: 20px;}
    .view-display-id-block_2 .views-row{width: 300px;height: 350px; margin-bottom: 20px;}
    
    .content .view-display-id-block_1{padding:20 20px 17px; margin:  0 0 40px; width: 95%;}
    .encabezado .content .view-display-id-block .view-content .views-row{width:  300px;}
    .encabezado .content .view-display-id-block .view-content .views-row-1,  .encabezado .content .view-display-id-block .view-content .views-row  {box-shadow:  0 3px 2px  rgba(0, 0, 0, 0.3);}
    .view-id-general_tipos_contenido.view-display-id-block{margin-top: 20px; padding-top: 20px; width: auto; height: 240px; background: none;}
    .view-id-general_tipos_contenido.view-display-id-block_2{margin: 50px auto; overflow: hidden;}
    .content .view-display-id-block_1 .views-row{height: 424px; width: 100%;}
    .view-display-id-block_2 .views-row{height: 380px;}
  }/*780px*/

  @media screen and (max-width: 480px){
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
    .logo-areacaribe{
      display: none;
    }
    body .content .view-display-id-block_1{
      width: 95%;
      padding: 10px;
    }
    body .paginadores-corto{
      display: none;
    }
    #footer .contenedor{
      width: 320px;
    }
    body .view-display-id-block_1 .view-content{
      width: 100%;
    }
    body .encabezado .content .view-content .views-row img{
      width: 100%;
      height: auto;

    }
    .slider-block .encabezado{
      width: 100%;
    }
    body .encabezado .content .view-content .views-row{
      width: 100%;
      height: auto;
      margin: 0 auto;
      float: none;
    }
    body .te-quedaste-corto{
      width: 90%;
    }
    body .view-display-id-block{
      width: 95%;
      padding: 10px;
    }
    body .encabezado .content .view-display-id-block .view-content .views-row{
      width: 100%;
      height: auto;
    }
    body .box-tittle {
      width: 100%;
    }
    body .encabezado .content .view-display-id-block .view-content .views-row div:first-child,body .encabezado .content .view-display-id-block .view-content .views-row div{
      width: 100%;
      height: auto;
    }
    body .view-display-id-block_1 .views-row h2.titulo{
      width: 95%;
      top: 157px;
    }
    body .sombra-title {
    display: none;
    }
    body .view-display-id-block_1 .views-row .views-field-field-sumario{
      display: none;
    }
    body .view-display-id-block_4 {
    width: 100%;
    padding: 0px;
    height: 1050px;
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
    transition: all 0.9s ease-in-out;
    -webkit-transition: all 0.9s ease-in-out;
    -moz-transition: all 0.9s ease-in-out;
    -o-transition: all 0.9s ease-in-out;
    -ms-transition: all 0.9s ease-in-out;
    }
    body ul.menu-feria {
    width: 100%;
    border: none;
    top: 20px;
    background-color: transparent;
    margin-top: 10px;
    position: inherit;
    }
    body ul.menu-feria li {
    width: 33%;
    border-right: medium none;
    height: 26px;
    padding-top: 5px;
    display: none;
    }
    body .view-display-id-block_4 .view-content {
      width: 100%;
    }
    body .view-display-id-block_4 .views-row {
      width: 94%;
      float: none;
      text-align: center;
      margin-right: 0px;
    }
    .slider-block{width:auto;}
    .logo-feria{background-size: 100%;}
    .redes-sociales{float:none;display: block;text-align: center;margin: 15px 0px;}
    .section-logos{height: 160px;}
    .back-container {/*max-height: 580px; */height: auto;background-position-y: -220px;}
    .te-quedaste-corto{width:auto;}
    .box-tittle{width:auto;}
    body.sidebar-first #main{width: 320px;overflow: hidden;}
    #main-home{width: 320px;margin: 0 auto;overflow: hidden;}
    .back-container-two{padding: 10px 0px;margin-top: 20px;}
    .view-id-general_tipos_contenido.view-display-id-block{height: 560px;}
  }/*480*/
</style>