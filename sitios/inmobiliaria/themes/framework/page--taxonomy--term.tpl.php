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
  <div class="ruta">
      <nav>
          <a href="/#empresas">Constructoras<span>></span></a>
          <span><?php echo $title?></span>
      </nav>
  </div>
  <div class="slider-block box-constructoras">
    <section id="slider">
    	<?php $view = views_get_view('view_term_empresas'); print $view->preview('block_1'); ?>
      <?php //$view = views_get_view('frontpage'); print $view->preview('block_11'); ?>
    </section>
  </div>

  <div id="proyectos_detalle_empresa">
      <div class="box-tittle">
        <h2>Proyectos</h2>
      </div>
    <?php $view = views_get_view('general_tipos_contenido'); print $view->preview('block_4'); ?>
  </div>
  
</div><!-- back container -->

<div class="back-container-two">
  <div class="te-quedaste-corto">
    <div class="box-tittle"><h2 style="width:250px;">Otros proyectos</h2></div>
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
    </div>
  </div>
</div>

<style>
  body #slider{background: #fff;}
    .back-container {background-position: center -230px;}
    @media screen and (max-width: 819px){
        .back-container {background-position: center -100px;}
    }
  @media screen and (max-width: 780px){
      .back-container {background-position: center -140px;}
    .view-display-id-block_1 .views-row{
      width: 100%;
    }
    .view-display-id-block_1 .view-content{
      width: 100%;
    }
    .view-display-id-block_1{
      text-align: center;
    }
  }
    @media screen and (max-width: 700px){
        .back-container {background: #FFF;}
        .slider-block.box-constructoras {width: 100%;box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);}
        #slider {margin: 0 0 20px;}
    }
    @media screen and (max-width: 667px){
        .slider-block.box-constructoras {width: 90%;
    }
  @media screen and (max-width: 480px){
    body .view-display-id-block_1 .views-row {
      width: 100%;
    }
    .back-container{
      height: auto;
    }
  }
  .view-display-id-block_1 .views-row {
    font-family: "Jaldi",sans-serif;
    z-index: 1;
    width: 980px;
    overflow: hidden;
    float: left;
    margin: 0 0px 0 0;
    position: relative;
    padding: 0;
    border: 0;
    padding-bottom: 20px;
  }
  .view-display-id-block_1 { background-color: #fff; height: inherit;}
  #proyectos_detalle_empresa .views-field-nothing{ position: relative; height: 196px;}
  #proyectos_detalle_empresa .views-field-nothing img{ position: absolute; top: 0; left: 0; transition:0.8s;}
  #proyectos_detalle_empresa .views-field-nothing a:nth-child(2) img:hover{ opacity: 0;}
</style>

<script>
  $(document).ready(function(){
    cargaSlider_tequedastecorto();
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