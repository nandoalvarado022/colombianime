<?php
  foreach($_POST as $nombre_campo => $valor){
     $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
     eval($asignacion);
  }

  if (isset($origen)) {
    print $page;
  } else{?>
    <!DOCTYPE html>
    <?php
    require_once ('sites/all/libraries/mobile-detect-master/mobile_detect.php');
    $detect = new Mobile_Detect();
    $_SESSION["isMobile"]=$detect->isMobile();
    ?>
    <script>
      var isMobile="<?php echo $detect->isMobile();?>";
    </script>
    <?php
    // if ($detect->isMobile()) {
    // // Detecta si es un móvil
    // }
    // if ($detect->isTablet()) {
    // // Si es un tablet
    // }
    // if ($detect->isAndroidOS()) {
    // // Si es Android
    // }
    // if ($detect->isiOS()){
    //  //Si es iOS
    // }
    ?>
    <!--[if lt IE 7]> <html class="ie6 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
    <!--[if IE 7]>    <html class="ie7 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
    <!--[if IE 8]>    <html class="ie8 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
    <!--[if gt IE 8]> <!--> 
    <html class="" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <!--<![endif]-->
    <head>
      <?php print $head; ?>
      <!-- Set the viewport width to device width for mobile -->
      <meta name="viewport" content="width=device-width" />
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="msvalidate.01" content="D5D05B1AAFCF0F5D4BBB8969372AC190" />
      <title><?php print $head_title; ?></title>
      <meta name=”description” content="Encontraras todas tus tiendas anime, todo sobre Cosplayer, Eventos anime en Colombia, Noticias anime, Concursos y mas"/>
      <meta property="fb:pages" content="195187767526205" />
      <?php print $styles; ?>
      <?php print $scripts; ?>
      <!-- IE Fix for HTML5 Tags -->
      <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

      <!--jQuery-->
      <!--<script type="text/javascript" src="http://localhost/misc/jquery.js?v=1.4.4"></script>-->
      <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
      <!--
      <script type="text/javascript" src="http://localhost/misc/jquery.once.js?v=1.2"></script>-->
      <!--jQuery-->


      <script src="/files/js/jquery.colorbox-min.js"></script>
      <script src="/files/js/jquery.easing.1.3.js"></script>
      <script src="/files/js/jquery.easing.compatibility.js"></script>
      <script src="/sites/all/themes/framework/general.js"></script>
      <!-- 
      <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
       -->
       <!-- font -->
      <link href='https://fonts.googleapis.com/css?family=Titan+One' rel='stylesheet' type='text/css'>
       <!-- / font -->
      <link rel="icon" type="image/png" href="/files/images/fav_icon.png" />
      <link rel="stylesheet" href="/sites/all/themes/framework/css/animate.css">
      <link rel="stylesheet" href="/files/css/colorbox.css" />
      
      <!-- Slider -->
      <link href="/files/owl-carousel/owl.carousel.css" rel="stylesheet">
      <link href="/files/owl-carousel/owl.theme.css" rel="stylesheet">
      <script src="/files/owl-carousel/owl.carousel.js"></script>

      <link rel="stylesheet" href="/sites/all/themes/framework/css/estilosJesu.css" />

      <link rel="stylesheet" href="/sites/all/themes/framework/misestilos.css?update=<?= time()?>" />
      <link rel="stylesheet" type="text/css" href="/sites/all/themes/framework/misestilos-movil.css" media="screen and (max-width:480px)">


      <!-- Facebook Pixel Code Anuncio Elen Black -->
      <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
      n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','https://connect.facebook.net/en_US/fbevents.js');

      fbq('init', '1175346225819259');
      fbq('track', "PageView");</script>
      <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1175346225819259&ev=PageView&noscript=1"
      /></noscript>
      <!-- End Facebook Pixel Code -->


      <script>


      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-71499356-1', 'auto');
      ga('send', 'pageview');
      </script>

      <script>
        $(document).ready(function(){
          $(".ver_mas_nota").click(function(){
            $(this).parent().find(".cuerpo").css("height", "auto");
          });
          
          ver_contacto_productos_der();

          $(".galeria .btn-body").click(function(){
            $(this).html("Información:");
            $(this).parent().find(".body").slideDown();
          });

          $(".galeria .sig").click(function(){
            obj=$(this).parent().find(".content");
            left=obj.css("margin-left");
            left=left.replace("px", "");
            left=parseInt(left);
            left=left-270;
            console.log(left);
            obj.css("margin-left", left+"px");
          });

          $(".galeria .ant").click(function(){
            obj=$(this).parent().find(".content");
            left=obj.css("margin-left");
            left=left.replace("px", "");
            left=parseInt(left);
            left=left+270;
            console.log(left);
            obj.css("margin-left", left+"px");
          });

          $(".galeria a").attr("target", "_BLANK");
        }); //Ready

        var ocupado_contacto_productos_der=false;
        function ver_contacto_productos_der(){
          $("#main .izq .item-list .galeria").mouseenter(function(){
            if (ocupado_contacto_productos_der==true) {return false;}
            ocupado_contacto_productos_der=true;
            obj=$(this);
            obj.find(".body").slideDown(1000, "easeInBounce", function(){
              ocupado_contacto_productos_der=false;
            });
          }).mouseleave(function(){
            if (ocupado_contacto_productos_der==true) {return false;}
            ocupado_contacto_productos_der=true;
            obj=$(this);
            obj.find(".body").slideUp(1000, "easeOutBounce", function(){
              ocupado_contacto_productos_der=false;
            });
          });
        }
      </script>

      <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NSLBN7"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NSLBN7');</script>
      <!-- End Google Tag Manager -->

    </head>

      <body class="<?php print $classes; ?>" <?php print $attributes;?>>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '980690795346065',
              xfbml      : true,
              version    : 'v2.5'
            });
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/es_CO/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
        <section class="list-cosplayer">
          <figure class="bg"></figure>
          <article class="izq">
            <figure class="bg"></figure>
            <img src="/files/images/bg-07.png" alt="">
            <img src="/files/images/bg-02.png" alt="">
            <img src="/files/images/bg-03.png" alt="">
          </article>    
          <article class="centro">
            Colombianime
          </article>
          <article class="der">
            <figure class="bg"></figure>
            <img src="/files/images/bg-04.png" alt="">
            <img src="/files/images/bg-05.png" alt="">
            <img src="/files/images/bg-06.png" alt="">
          </article>    
        </section>
        <!-- FB -->
          <!-- <div id="fb-root"></div> -->
          <script>
          //   (function(d, s, id) {
          //   var js, fjs = d.getElementsByTagName(s)[0];
          //   if (d.getElementById(id)) return;
          //   js = d.createElement(s); js.id = id;
          //   js.src = "//connect.facebook.net/es_CO/sdk.js#xfbml=1&version=v2.5&appId=1525358061109357";
          //   fjs.parentNode.insertBefore(js, fjs);
          // }(document, 'script', 'facebook-jssdk'));</script>
          </script>
        <!-- Fin FB -->
        <header id="header" class="region-header" role="banner" class="clearfix">
          <?php print views_embed_view('frontpage','block_13'); ?>
          <figure class="content_logo" id="logo-colombianime">
            <a href="/">
              <img src="/files/images/logo-colombianime.png" alt="Logo Colombianime">
            </a>
          </figure>
          <ul style="display:none;">
            <!-- <li>
              <a href="">
                <img src="sites/all/themes/framework/img/find.png" alt="" class="icon-find">
              </a>
              <input type="text" class="hide">
            </li> -->
            <li>
              <a href="/paso-algo">CONTACTANOS</a>
            </li>
            <!-- <li>
              <a href="">GALERIAS</a>
            </li> -->
            <li>
              <a href="/#listado-productos" class="">LO QUE BUSCAS</a>
            </li>

            <li>
              <a href="/" class="active">INICIO</a>
            </li>

            
              <!--
              <li class="logo">
                <a href="http://colombianime.com">
                  <img src="http://colombianime.com/files/images/colombia-anime.jpg" alt=""> 
                </a>
              </li>-->
              
              <!--<li class="buscador">
                <script>
                  (function() {
                    var cx = '013354508874791541030:p0ok2em_l3q';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                        '//cse.google.com/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                  })();
                </script>
                <gcse:search></gcse:search>
              </li>-->
              <!--
              <li class="redes-sociales">
                <?php // include("social_buttons_new.tpl.php"); ?>
              </li>-->
            </ul>  
        </header> <!-- /#header -->
        <div class="container">
          <div class="AnuncioCol Anu1200x100"></div>
          <!-- Popup suscripcion -->
            <div style="display:none;">
              <div id="formSuscribetePOPUP">
                <div class="letrero-ama">
                  <span>¡Suscribete!</span>
                </div>

                <div class="letrero-verde animated bounceInLeft">
                  <span>Ahora dale link y comparte</span>
                </div>

                  <div class="fb-page" data-href="https://www.facebook.com/colombianimeCO" data-width="380" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
                </div>

                <form id="datos">
                  <input type="text" name="nombre" placeholder="Dinos tu nombre">
                  <input type="text" name="correo" placeholder="Correo electronico">
                  <button>Enviar</button>
                </form>
                <div style="clear:both;"></div>
              </div>
            </div>
          <!-- Fin Popup suscripcion -->

        <?php print $page_top; ?>
        <?php print $page; ?>
        <?php print $page_bottom;?>
        <?php //echo "La variable es:".$_GET["q"];?>
        <!-- chat -->
          <?php
          $useragent="";
          if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){?>
            <!--<script id="cid0020000111669219398" data-cfasync="false" async src="//st.chatango.com/js/gz/emb.js" style="width: 300px;height: 350px;">{"handle":"diarioanime","arch":"js","styles":{"a":"0084ef","b":100,"c":"FFFFFF","d":"FFFFFF","k":"0084ef","l":"0084ef","m":"0084ef","n":"FFFFFF","p":"11.34","q":"0084ef","r":100,"pos":"br","cv":1,"cvbg":"33ccff","cvw":200,"cvh":30,"surl":0,"cnrs":"0.48","ticker":1,"fwtickm":1}}</script>-->
            <?php
          }?>


          <script>
          effects=Array("tada", "bounce", "wobble", "bounceIn", "flip");
          window.setInterval(function(){
            animation=effects[Math.floor(Math.random() * effects.length)];//aleatorio
            element = $("#logo-colombianime");
            element.addClass('animated ' + animation);
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);
          }, 30000);
          </script>
      </body>
    </html>
    <?php
  }
?>