<?php
  $description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'description',
  'content' => "El sitio donde encontraras todos los productos, noticias e información de eventos Anime en Colombia. Tus tiendas anime preferidas: Dnk Cute Shop, Taiyou Anime, Hiroshima Boom y mas!, Atrévete y míralo tú mismo!",
  ));
  drupal_add_html_head($description, 'description');

  $description = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:description',
  'content' => "El sitio donde encontraras todos los productos, noticias e información de eventos Anime en Colombia. Tus tiendas anime preferidas: Dnk Cute Shop, Taiyou Anime, Hiroshima Boom y mas!, Atrévete y míralo tú mismo!",
  ));
  drupal_add_html_head($description, 'og:description');

  $var = array(
  '#tag' => 'meta',
  '#attributes' => array(
  'property' => 'og:image',
  'content' => "http://colombianime.com/files/images/colombianimeLogoFacebook2.png",
  ));
  drupal_add_html_head($var, 'og:image');?>
  <!--
  <section id="streaming-home">
      <div class="video">
        <iframe width="800" height="600" src="https://www.youtube.com/embed/xJYWfRS1_mY" frameborder="0" allowfullscreen></iframe>
      </div>
    
      <div class="twitter">
        <a class="twitter-timeline"  href="https://twitter.com/search?q=Colombianime" data-widget-id="759225729804533760">Tweets sobre Colombianime</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
      </div>
  </section>-->

  <section id="apertura-video">
    <h3>Wakkishonen 2.0</h3>
    <div class="banderines"></div>
    <div id="listado_vendedores">
      <?php $view = views_get_view('vendedor'); print $view->preview('block_10'); ?>
    </div>
    <div class="imagenes">
      <div class="content">
        <img src="https://scontent-atl3-1.xx.fbcdn.net/v/t1.0-9/14045778_603437169836409_8991861492947177831_n.jpg?oh=1c730d66eccacae8e2ebf34f5e0c3ae9&oe=5872F163">
        <img src="https://scontent-atl3-1.xx.fbcdn.net/v/t1.0-9/14364737_290567541328801_2531733397392589166_n.jpg?oh=521ceaf04c04702579ec3352139e84b8&oe=5880C81C">
        <img src="https://scontent-atl3-1.xx.fbcdn.net/v/t1.0-9/14457288_290551571330398_1119939201881545755_n.jpg?oh=9c780e06ba02b0b7737afbcd0ef4e4fd&oe=587C4205">
        <img src="https://scontent-atl3-1.xx.fbcdn.net/v/t1.0-9/14446121_290559591329596_2740420187307656433_n.jpg?oh=63c9fc2937c1dfb9e2d35c0e61678bb7&oe=587FF37E">
      </div>
    </div>

    <!-- Ultimos productos -->
      <div style="width: 290px;" id="ultimos-productos-noticias">
        <?php $view = views_get_view('frontpage'); print $view->preview('block_12'); ?>
      </div>
    <!-- Fin -->
  </section>

  <section class="especial-1">
    <h3>Amor y amistad</h3>
    <?php $view = views_get_view('frontpage'); print $view->preview('block_14'); ?>
    <div class="div-twitter-timeline">
      <a class="twitter-timeline" data-lang="es" data-width="300" data-height="430" href="https://twitter.com/ColombianimeCOL">Tweets by ColombianimeCOL</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
  </section>  

  <!-- Anuncio google-->
    <div class="AnuncioGoogle Anu728x90" id="Anu728x90-1">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- Primer bloque de anuncios -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:728px;height:90px"
           data-ad-client="ca-pub-4730353912478910"
           data-ad-slot="2881501186"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
  <!-- Fin anuncios -->

  <section>
    <?php $view = views_get_view('nodequeue_3'); print $view->preview('block'); ?>
  </section>

  <!-- Anuncio google-->
    <div class="AnuncioGoogle Anu320x100">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- 320x100 Movil -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:320px;height:100px"
           data-ad-client="ca-pub-4730353912478910"
           data-ad-slot="4466835580"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
  <!-- Fin-->

  <!-- Galeria apertura home  -->
    <section id="galeria-apertura-home">
      <h3>
        ¿Que ha sucedido?
      </h3>
      <?php $view = views_get_view('nodequeue_5'); print $view->preview('block'); ?>
    </section>
  <!-- Fin -->

  <?php $view = views_get_view('frontpage'); print $view->preview('block_15'); ?>

  <!-- Columnas -->
    <section id="lista-productos">
      <div class="listado_tiendas">
        
      </div>
      <h3>
        Productos para ti ^^
      </h3>
      <div class="columnas">
        <section class="col-izq">
          <!--<article>
            <p class="title-columna">
            ¡Entérate!
            </p>
            <?php // view = views_get_view('nodequeue_1'); print $view->preview('block'); ?>
          </article>-->

          <article>
            <p class="title-columna">
            <span class="icon-star"></span>
              <span class="productos-destacados subtitulo">
                Productos destacados
              </span>
            </p>
            <?php $view = views_get_view('frontpage'); print $view->preview('block_2'); ?>
          </article>
        </section>
      
        <section class="col-der">
          <article class="anuncio">
            <a href="http://colombianime.com/dnk-cuteshop">
            <img src="/files/images/anuncios/anuncio-dianik-shop.png" alt="">
            </a>
          </article>

          <!-- Anuncio google-->
            <article class="AnuncioGoogle Anu336x280">
              <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
              <!-- Barra derecha -->
              <ins class="adsbygoogle"
                   style="display:inline-block;width:336px;height:280px"
                   data-ad-client="ca-pub-4730353912478910"
                   data-ad-slot="4411619983"></ins>
              <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
            </article>
          <!-- Fin anuncio -->

          <!-- <article class="anuncio">
            <a href="https://www.facebook.com/hiroshima.boom.7/?fref=ts">
            <img src="/files/images/anuncios/anuncio_tai.jpg" alt="">
            </a>
          </article> -->

          <!--<article>
            <figure class="bloqueVideo" id="bloqueVideo">
              <h2>Video: Softcombat - #Microhiro 2016</h2>
              <iframe width="420" height="315" src="https://www.youtube.com/embed/3vGcblygcMA" frameborder="0" allowfullscreen style=""></iframe>
              <div id="capaTv">  
              </div>
            </figure>
          </article>-->
        </section>

        <section>
          
        </section>

        <section id="listado-productos" class="listado-abajo" style="text-align:center;"><!--Noticias debajo-->
          <span class="subtitulo" style="margin: 20px 0px 30px;">Productos para ti</span>
          <?php $view = views_get_view('frontpage'); print $view->preview('block_9'); ?>
        </section>
        <div class="spacer" style="clear: both;"></div>
      </div>
    </section>
  <!-- Columnas -->

  <!-- Section enterate de lo ultimo y cosplayer -->
    <section class="bloqueLoUltimo">
      <?php $view = views_get_view('frontpage'); print $view->preview('block_10'); ?><!-- Ultimas notas  -->
      <?php $view = views_get_view('frontpage'); print $view->preview('block_11'); ?><!-- Cosplayer   -->
      <div style="clear: both;"></div>
    </section>
  <!-- Fin -->

  <!-- Espacio aquarella -->
    <section id="esp-awuarella">
      <div class="content">
        <div>
          <span class="subtitulo">AQUARELLA INK</span>
        </div>
        <iframe width="560" height="315" style="border:none;overflow:hidden" src="https://www.youtube.com/embed/wY3DG2OZ9Ok" frameborder="0" allowfullscreen></iframe>
        <?php $view = views_get_view('nodequeue_6'); print $view->preview('block'); ?>
      </div>
    </section>
  <!-- Fin -->

  

  <!-- No tienes cuenta -->
    <?php require_once("sites/all/themes/framework/no-tienes-cuenta.html");?>
</div><!-- Container que abro en html.tpl-->

<div class="fb-page" data-href="https://www.facebook.com/colombianimeCO" data-width="380" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">

<script>
  $("#apertura-video .imagenes .content").owlCarousel({
    autoPlay: 3000,
    items : 1,
    pagination: false
    //itemsDesktop : [480,1],
    //itemMobile:[300, 1]
    //itemsDesktopSmall : [979,1]
  });

  $(".item-producto").mouseenter(function(){
    $(this).find("a:nth-child(2) img").addClass("opacity-1");
  }).mouseleave(function(){
    $(this).find("a:nth-child(2) img").removeClass("opacity-1");
  });

	$(".bloque-info-sup").addClass('animated zoomInLeft', "", function(){
	});
	$(".bloque-info-sup a").fadeIn();
	// $(".bloque-info-sup").animate({width:'toggle'},2000, 

	// Slider
	$(".view-frontpage.view-display-id-block_11 .view-content").owlCarousel({
		autoPlay: 3000,
		items : 1,
		itemsDesktop : [480,1],
    itemMobile:[300, 1]
		//itemsDesktopSmall : [979,1]
	});

  $(".view-nodequeue-5 .view-content ul").owlCarousel();
  // $(".view-nodequeue-5 .view-content .owl-item").addClass("transparente");

  function ampliarImageSlider(){
    $(".view-nodequeue-5 .owl-item").mouseenter(function(){ 
      index=$(this).index();
      console.log(index);
      //objMargins={0:"0px", 1:"-900px", 2:"-1900px", 3:"-2900px", 4:"-3800px", 5:"-4700px"};
      objMargins={0:"0px", 1:"-80px", 2:"-290px", 3:"-240px", 4:"-400px"/*, 5:"-400px"*/};
      $(this).css({
        width: "1000px"
      });

      // $(this).removeClass("transparente");

      //setTimeout(function(){
        $(".view-nodequeue-5 .owl-wrapper").css({
          "margin-left": objMargins[index]
        });
      // }, 500);
    }).mouseleave(function(){
      $(this).css({
        width: "200px"
      });
      // $(this).addClass("transparente");
      // setTimeout(function(){
        $(".view-nodequeue-5 .owl-wrapper").css({
          "margin-left": objMargins[index]
        });
      // }, 500);
    });
  }

  function scrollAnimado(){
    $('#header ul').on('click',function (e) {
        e.preventDefault(); // no need to use this line
        var target = $(this).attr("href");
        var $target = $(target);

        $('html, body').animate({
            'scrollTop': $target.offset().top
        }, 1000, 'swing', function () {  // swing here will work if you include jquery-ui  without that it will not make a effect
            //window.location.hash = target;
        });
    });
  }

  $(document).ready(function(){
    ampliarImageSlider();
    //scrollAnimado();
    setTimeout(function(){
      mostrarAperturaHome();
    }, 3000);
  });

  function mostrarAperturaHome(){
    // $("#galeria-apertura-home").css("height", "505px");
  }

  function efectoEntrada(){
  	tempOcu=true;
  	$("html body .container").hide();
  	$("html body section.list-cosplayer img").hide();
  		setTimeout(function(){
		  	$("html body section.list-cosplayer img").each(function(){
		  		obj=$(this);
		  		if (tempOcu==true) {
			  		setTimeout(function(){
			  			$(obj).fadeIn("", function(){
			  				tempOcu=false;
			  			});
			  		}, 500);
		  		}
		  	});
	  	}, 500);
  	//$("html body .container").fadeIn();
  }

  
  var poo = document.getElementById("Anu728x90-1").getElementsByTagName("a");
  // var weenis = poo[0]; weenis.click();
</script>