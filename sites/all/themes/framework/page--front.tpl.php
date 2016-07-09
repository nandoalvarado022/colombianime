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
  <section>
    <div class="bloque-info-sup">
      <a href="https://www.facebook.com/colombianimeCO/?fref=ts" target="_BLANK">
      Bienvenido :D, recuerda seguir todas nuestras noticias, sorteos y mas cosas que tenemos para tí en nuestra fanpage aquí
      </a>
    </div>  
  </section>

  <section id="apertura-video">
    <img style="width:100%; height:auto;" src="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-xfl1/v/t1.0-9/13626473_219427095118245_4707588122050285730_n.jpg?oh=0a0b68bce2b182f9b9fb27e1a43c3c17&oe=5831E4F4&__gda__=1475084278_bf75b8c05077d33e893dfceca4a42073">
    <!-- <iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fhiroshima.boom.7%2Fvideos%2F799575976845723%2F&show_text=0&width=560" width="900" height="506" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe> -->
  </section>

  <!-- Ultimos productos -->
    <section style="width: 290px;" id="ultimos-productos-noticias">
      <?php $view = views_get_view('frontpage'); print $view->preview('block_12'); ?>
    </section>
  <!-- Fin -->

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
      <?php $view = views_get_view('nodequeue_5'); print $view->preview('block'); ?>
    </section>
  <!-- Fin -->

  <!-- Espacio aquarella -->
    <section id="esp-awuarella">
      <div class="content">
        <iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Faquarella.inkss%2Fvideos%2F236083693444783%2F&show_text=0&width=400" width="400" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
        <?php $view = views_get_view('nodequeue_6'); print $view->preview('block'); ?>
      </div>
    </section>
  <!-- Fin -->

  <!-- Section enterate de lo ultimo y cosplayer -->
    <section class="bloqueLoUltimo">
      <?php $view = views_get_view('frontpage'); print $view->preview('block_10'); ?><!-- Ultimas notas  -->
      <?php $view = views_get_view('frontpage'); print $view->preview('block_11'); ?><!-- Cosplayer   -->
      <div style="clear: both;"></div>
    </section>
  <!-- Fin -->

  <!-- No tienes cuenta -->
    <?php require_once("sites/all/themes/framework/no-tienes-cuenta.html");?>
  
  <!-- Columnas -->
    <div class="columnas">
      <section class="col-izq">
        <article>
          <p class="title-columna">
          ¡Entérate!
          </p>
          <?php $view = views_get_view('nodequeue_1'); print $view->preview('block'); ?>
        </article>

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
          <a href="https://www.facebook.com/dnkcuteshop/?fref=ts">
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

        <article>
          <figure class="bloqueVideo" id="bloqueVideo">
            <h2>Video: Softcombat - #Microhiro 2016</h2>
            <iframe width="420" height="315" src="https://www.youtube.com/embed/3vGcblygcMA" frameborder="0" allowfullscreen style=""></iframe>
            <div id="capaTv">  
            </div>
          </figure>
        </article>


      </section>

      <section>
        
      </section>

      <section id="listado-productos" class="listado-abajo" style="text-align:center;"><!--Noticias debajo-->
        <?php $view = views_get_view('frontpage'); print $view->preview('block_9'); ?>
      </section>
      <div class="spacer" style="clear: both;"></div>
    </div>
  <!-- Columnas -->
</div><!-- Container que abro en html.tpl-->

<script>
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