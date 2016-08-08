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
    drupal_add_html_head($og_description, 'og_description');

$description = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'name' => 'description',
    'content' => "Encuentre casas, apartamentos, oficinas, bodegas, fincas y m&#xe1;s inmuebles en venta y arriendo. Areacaribe.com.co el sitio web para vender su inmueble.",
    ));
    drupal_add_html_head($description, 'description');?>
  <div class="slider-block">
    <section id="slider">
      <!-- slider nuevo -->
        <!-- Owl Carousel Assets -->
        <div id="demo">
            <div class="container">
              <div class="row">
                <div class="span12">
                  <div id="owl-demo" class="owl-carousel owl-principal">
                    <!--<div class="item"><img src="/themes/framework/assets/fullimage3.jpg" alt="Mirror Edge"></div>-->
                    <?php $view = views_get_view('frontpage'); print $view->preview('block_13');?>
                  </div>
                </div>
              </div>
            </div>
        </div>
                
        <script>
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

          function cargaSlider(){
            html=$(".view-frontpage.view-display-id-block_13 .view-content").html();
            $("#demo #owl-demo.owl-principal").html(html).promise().done(function(){
              $("#owl-demo.owl-principal").owlCarousel({
              navigation : true, // Show next and prev buttons
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem:true
              // "singleItem:true" is a shortcut for:
              // items : 1, 
              // itemsDesktop : false,
              // itemsDesktopSmall : false,
              // itemsTablet: false,
              // itemsMobile : false
              });
            });
          }

          function cargaSlider_empresas(){
            html=$(".view-id-view_term_empresas .view-content").html();
            $("#demo #owl-demo.owl-empresas").html(html).promise().done(function(){
              $("#owl-demo.owl-empresas").owlCarousel({
              navigation : true, // Show next and prev buttons
              slideSpeed : 300,
              paginationSpeed : 400,
              //singleItem:true,
              // "singleItem:true" is a shortcut for:
              items : 1,
              itemsDesktop : [981800, 4],
              itemsDesktopSmall : [900, 4],
              itemsTablet: [800, 3],
              itemsMobile : [480, 2]
              });
            });
          }

          $(function() {
            cargaSlider();
            cargaSlider_empresas();
            cargaSlider_tequedastecorto();
          });
        </script>
        
        <!-- Demo -->
        <style>
        #main-home .listado-proyectos .views-row .url{display: none;}
        #owl-demo .item img{
            display: block;
            width: 100%;
            height: auto;
        }
        </style>
      <!-- slider nuevo -->
    </section>
  </div>  
</div><!--back-container-->
 
  <!--<section id="main" role="main" class="clearfix">
    <?php  //print render($page['content']); ?>
  </section>--> <!-- /#main -->
  <div id="main-home">
    <div class="empresas" id="empresas">
      <div class="box-tittle"><h2>Constructoras</h2></div>

      <div id="demo">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div id="owl-demo" class="owl-carousel owl-empresas">
                <!--<div class="item"><img src="/themes/framework/assets/fullimage3.jpg" alt="Mirror Edge"></div>-->
                <?php $view = views_get_view('view_term_empresas'); print $view->preview('block'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="box-tittle"><h2>Constructoras</h2></div>
       <?php // $view = views_get_view('view_term_empresas'); print $view->preview('block'); ?>
      <div class="sombra-empresas"><img src="http://especiales.elheraldo.co/feriainmobiliaria/themes/framework/images/sombra.png"></div>
      <div class="pagerEmpresas">
        <ul>
          <li class="item1">1</li>
          <li class="item2">2</li>
          <li class="item3">3</li>
          <li class="item4">4</li>
          <li class="item5">5</li>
        </ul>
      </div>
       <div class="pagerEmpresas-movil">
        <ul>
          <li class="item1">1</li>
          <li class="item2">2</li>
          <li class="item3">3</li>
          <li class="item4">4</li>
          <li class="item5">5</li>
        </ul>
      </div> -->
    </div>
    <div class="listado-proyectos" id="proyectos">
      <div class="box-tittle"><h2>Ofertas</h2></div>
      <div class="sombra-title"></div>
      <?php $currentterm = "";
      $view = views_get_view('frontpage'); print $view->preview('block_3'); ?>
      <div class="ver-mas">Ver más</div>
    </div>
  </div>
  <div class="back-container-two">
    <div class="te-quedaste-corto">
      <div class="box-tittle"><h2 style="width:250px;">¿Te quedaste corto?</h2></div>
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
  <!--
  <footer id="footer" role="contentinfo" class="clearfix">
    <div class="contenedor">
      <div class="redes-footer"><?php // include("social_buttons_new_footer.tpl.php"); ?></div>
      <div class="text-evento-footer">
        <span>
          El evento más importante de las ofertas<br> inmobiliarias en Barranquilla
        </span>
      </div>
      <a href="http://elheraldo.co"><div class="logo-heraldo">Un producto de: </div></a>
    </div>
  </footer> 
  -->
  <!-- /#footer -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script>
  function event_popup_facebook(){
    $(".view-id-frontpage.view-display-id-block_3 .icono-like-edited").click(function(){
      link=$(this).attr("data-href");
      window.open('http://www.facebook.com/sharer.php?u='+link, 'mywindowtitle', 'width=500, height=150');
    });
  }
  $(function() {
    event_popup_facebook();
    /*var menu = $('.menu-feria');
    var contenedor = $('.container-menu');
    var menu_offset = menu.offset();
    $(window).on('scroll', function() {
      if($(window).scrollTop() > menu_offset.top) {
        menu.addClass('menu-fijo');
        } else {
        menu.removeClass('menu-fijo');
      }
    });*/
    $(".pagerEmpresas-movil .item2").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-360px");
      $(".pagerEmpresas-movil .item2").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas-movil .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas-movil .item1").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","0px");
      $(".pagerEmpresas-movil .item1").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas-movil .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas-movil .item3").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-720px");
      $(".pagerEmpresas-movil .item3").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas-movil .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas-movil .item4").click(function(){
      $(".view-id-view_term_empresas .view-content").css("left","-1080px");
      $(".pagerEmpresas-movil .item4").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas-movil .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas-movil .item5").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-1440px");
      $(".pagerEmpresas-movil .item5").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas-movil .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas-movil .item4").css({background:"#fff",border:"1px solid #ccc"});
    });
     $(".ver-mas").click(function(){
    var hm =  $(".listado-proyectos .view-display-id-block_3").height();
    var hmt = hm + 1920;
    $(".listado-proyectos .view-display-id-block_3").css("height",hmt + "px");
    $(".ver-mas").fadeOut();
    });
     $(".ver-mas-dos").click(function(){
    var hm =  $(".te-quedaste-corto .view-display-id-block_4").height();
    var hmt = hm + 990;
    $(".te-quedaste-corto .view-display-id-block_4").css("height",hmt + "px");
    $(".ver-mas-dos").fadeOut();
    });
     var x = 0;
    $(".paginadores-corto .pag-corto-right").click(function(){
      x = parseInt(x) - 950;     
      var xx = x + "px";      
      if ( ( x < -2850 ) ){        
        $(".view-display-id-block_4 .view-content").css("left","0");
        x = 0
      }else{
        $(".view-display-id-block_4 .view-content").css("left",xx);
      }
    });
    $(".paginadores-corto .pag-corto-left").click(function(){
      x = parseInt(x) + 950;      
      var xx = x + "px";     
      if ( ( x > 0 ) ){        
        $(".view-display-id-block_4 .view-content").css("left","-2850px");
        x = -2850
      }else{
        $(".view-display-id-block_4 .view-content").css("left",xx);
      }
    });
    $(".proyectos").click(function() {
      $('html, body').animate({
      scrollTop: $(".listado-proyectos").offset().top
      }, 1000);
    });
    $(".constructoras").click(function() {
      $('html, body').animate({
      scrollTop: $("#main-home").offset().top
      }, 1000);
    });
    $('.view-display-id-block_3 .views-row a.icono-like-edited').on('click', function(){
      $(this).replaceWith("<a class='icono-like-edited-visted'></a>");
    });

    $(".pagerEmpresas .item2").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-1000px");
      $(".pagerEmpresas .item2").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas .item1").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","0px");
      $(".pagerEmpresas .item1").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas .item3").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-2000px");
      $(".pagerEmpresas .item3").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item4").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas .item4").click(function(){
      $(".view-id-view_term_empresas .view-content").css("left","-3000px");
      $(".pagerEmpresas .item4").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item5").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".pagerEmpresas .item5").click(function(){
      $(".empresas .view-id-view_term_empresas .view-content").css("left","-4000px");
      $(".pagerEmpresas .item5").css({background:"#7D7D7D",border:"1px solid #7D7D7D"});
      $(".pagerEmpresas .item2").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item1").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item3").css({background:"#fff",border:"1px solid #ccc"});
      $(".pagerEmpresas .item4").css({background:"#fff",border:"1px solid #ccc"});
    });
    $(".view-display-id-block_4 .views-row").mouseover(function(){
    $(this).find(".info_especial").css({opacity:"1"});
    });
    $(".view-display-id-block_4 .views-row").mouseleave(function(){
    $(this).find(".info_especial").css({opacity:"0"});
    }); 
    var x = 0;
    $(".paginadores .pag-right").click(function(){
      x = parseInt(x) - 1010;     
      var xx = x + "px";      
      if ( ( x < -4040 ) ){        
        $(".view-display-id-block_1 .view-content").css("left","0");
        $(".pagerNoticas .item1").css({background:"#F5F53C",border:"1px solid #F5F53C"});
        $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
        $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
        $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
        $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        x = 0
      }else{
        $(".view-display-id-block_1 .view-content").css("left",xx);
        if ( ( xx == "-1010px" ) ){
          $(".pagerNoticas .item2").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-2020px" ) ){
          $(".pagerNoticas .item3").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-3030px" ) ){
          $(".pagerNoticas .item4").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-4040px" ) ){
          $(".pagerNoticas .item5").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
        }
      }
    });
    $(".paginadores .pag-left").click(function(){
      x = parseInt(x) + 1010;      
      var xx = x + "px";     
      if ( ( x > 0 ) ){        
        $(".view-display-id-block_1 .view-content").css("left","-4040px");
          $(".pagerNoticas .item5").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
        x = -4040
      }else{
        $(".view-display-id-block_1 .view-content").css("left",xx);
        if ( ( xx == "-1010px" ) ){
          $(".pagerNoticas .item2").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-2020px" ) ){
          $(".pagerNoticas .item3").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-3030px" ) ){
          $(".pagerNoticas .item4").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "-4040px" ) ){
          $(".pagerNoticas .item5").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item1").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
        }
        if ( ( xx == "0px" ) ){
          $(".pagerNoticas .item1").css({background:"#F5F53C",border:"1px solid #F5F53C"});
          $(".pagerNoticas .item2").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item3").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item4").css({background:"#fff",border:"1px solid #ccc"});
          $(".pagerNoticas .item5").css({background:"#fff",border:"1px solid #ccc"});
        }
      }
    });
  });
</script>


<style>
  @media(max-width: 768px){
    .back-container{background-position-y: -100px;}
  }
</style>