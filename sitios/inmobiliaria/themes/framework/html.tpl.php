
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 ie" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <![endif]-->
<!--[if gt IE 8]> <!--> 
<html class="" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"> <!--<![endif]-->
<head>
  <title>Área Caribe</title>
  <?php print $head;?>
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <link rel="shortcut icon" href="/themes/framework/images/favicon.ico">
  <link rel="stylesheet" type="text/css" href="/themes/framework/miestilo.css">
  <link href="/themes/framework/owl-carousel/owl.carousel.css" rel="stylesheet">
  <link href="/themes/framework/owl-carousel/owl.theme.css" rel="stylesheet">
  <link rel="stylesheet" href="/themes/framework/assets/css/animate.css">
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script src="/themes/framework/assets/js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="/themes/framework/general.js"></script>
  <script src="/themes/framework/owl-carousel/owl.carousel.js"></script>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->


<script>
// <!--ANALYTICS-->
  // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  // (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  // m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  // })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-44710758-12', 'auto');
  // ga('send', 'pageview');
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','// www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-35418911-6', 'auto');
  ga('send', 'pageview');
</script> 
   <!--END ANALYTICS-->

<script type="text/javascript">
  $(document).ready(function(){
    $("#nav_mobile li a").click(function(){
      ind=$(this).parent().index();
      if (ind==2 || ind==3) {
        if (tempNav_mobile==false) {
          $("#nav_mobile").slideUp();
            tempNav_mobile=true;
        } else{
          $("#nav_mobile").slideDown();
          tempNav_mobile=false;
        }
      }
    });
  });
</script>
</head>

<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div class="back-container">
    <header id="header" role="banner" class="clearfix">
      <?php // print render($page['header']); ?>
      <div class="section-logos">
        <a class="logo-feria" href="/"></a>
      </div>

      <div class="google_redes">
        <div class="buscador_google">
          <!-- 
          <script>
          (function() {
          var cx = '015423927131342042161:ixu9aq99ppg';
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
          -->
          <style>
            input[type=submit]{
              display: none;
            }
            input[name=custom_search_blocks_form_1], .search-form input{
              background: #FFF;
              border: none;
              padding: 7px 10px;
              outline: none;
              width: 240px;
              background-image: url(http://areacaribe.calipso.com.co/themes/framework/images/icono-buscar.svg);
              background-position: 0px 0px;
              background-repeat: no-repeat;
              border-radius: 15px;
              padding-left: 40px;
            }
          </style>
          <!-- <form class="search-form" action="/buscador" method="get" id="search-form" accept-charset="UTF-8" target="_self"> -->
          <form class="search-form" action="/buscador" method="get">
            <div class="container-inline form-wrapper" id="edit-basic">
              <div class="form-item form-type-textfield form-item-keys">
                <input type="hidden" name="field_apartamentos_desde_value" value="300000000">
                <input type="hidden" id="edit-field-apartamentos-desde-value-min" name="field_apartamentos_desde_value[min]" value="50000000" size="30" maxlength="128" class="form-text">
                <input type="hidden" id="" name="field_estrato_value" value="All" size="30" maxlength="128" class="form-text">

                <input type="hidden" id="edit-field-apartamentos-desde-value-max" name="field_apartamentos_desde_value[max]" value="10000000000" size="30" maxlength="128" class="form-text">

                <input placeholder="Buscas algo en especial?" type="text" id="edit-keys" name="title" value="" size="40" maxlength="255" class="form-text">
              </div>            
            </div>
          </form>
        </div><!--buscador google-->

        <div class="redes-sociales">
          <?php include("social_buttons_new.tpl.php"); ?>
        </div>
      </div>



      <div class="menu-mobile">
        <div class="menu_bar">
          <a class="bt-menu"><span class="list2"></span></a>
          <a id="btn_redes" data-display="block">Redes</a>
          <a class="logo-feria" href="/"></a>
        </div>
      </div>

      <nav id="nav_mobile">
        <ul>
        <li>
          <form class="search-form" action="/buscador" method="get">
            <div class="container-inline form-wrapper" id="edit-basic">
              <div class="form-item form-type-textfield form-item-keys">
                <input type="hidden" name="field_apartamentos_desde_value" value="300000000">
                <input type="hidden" id="edit-field-apartamentos-desde-value-min" name="field_apartamentos_desde_value[min]" value="50000000" size="30" maxlength="128" class="form-text">
                <input type="hidden" id="" name="field_estrato_value" value="All" size="30" maxlength="128" class="form-text">

                <input type="hidden" id="edit-field-apartamentos-desde-value-max" name="field_apartamentos_desde_value[max]" value="10000000000" size="30" maxlength="128" class="form-text">

                <input placeholder="Buscas algo en especial?" type="text" id="edit-keys" name="title" value="" size="40" maxlength="255" class="form-text">
              </div>            
            </div>
          </form>
        </li>
        <li><a href="/">INICIO</a></li>
        <li><a href="/secciones/listado-de-notas">NOTAS</a></li>
        <li><a href="/#proyectos" class="proyectos">PROYECTOS</a></li>
        <li><a href="/#empresas" class="constructoras">CONSTRUCTORAS</a></li>
        <li><a href="/secciones/sobre-nosotros">SOBRE NOSOTROS</a></li>
        <li><a href="/secciones/edicion-impresa">EDICIÓN IMPRESA</a></li>
        </ul>
      </nav>
      <div class="container-menu">
        <div class="div01">
          <ul class="menu-feria">
            <li>
              <span class="logo-menu">
                <a href="/"></a>
              </span>
              <a href="/" class="href-inicio">INICIO</a>
            </li>
            <li><a href="/secciones/listado-de-notas">NOTAS</a></li>
            <li><a href="/#proyectos" class="proyectos">PROYECTOS</a></li>
            <li><a href="/#empresas" class="constructoras">CONSTRUCTORAS</a></li>
            <li><a href="/secciones/sobre-nosotros">SOBRE NOSOTROS</a></li>
            <li><a href="/secciones/edicion-impresa">EDICIÓN IMPRESA</a></li>
          </ul>
        </div>
      </div>
    </header>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php //print $page_bottom; ?>

  <footer id="footer" role="contentinfo" class="clearfix">
    <div class="contenedor">
      <div class="section-logos">
        <a class="logo-feria" href="/"></a>
      </div>
      
      <div class="text-evento-footer">
        <p>
          Contactos PBX: (57) (5) 3715000 <br>
          ▪ Línea de atención: (57) (5) 3855050 - 018000 512200 <br>
          ▪ Calle 53B N° 46 - 25, Barranquilla - Atlántico <br>
          ▪ Oficina Bogotá: Calle 88 No. 13 A 07 | Teléfono: (1) 218 5733<br>
          ▪ Copyright EL HERALDO S.A. 2000 - 2015 Todos los derechos reservados.
        </p>
      </div>
      <a href="http://elheraldo.co"><div class="logo-heraldo">Un producto de: </div></a>
    </div>
  </footer>

  <style>
    .owl-carousel .owl-wrapper{margin: 0 auto;}
  </style>

  <script>
    /*Cambiar tamaño slider inferior*/
    size=$(".te-quedaste-corto .owl-item").size();
    switch(size){
      case 2:
        $(".te-quedaste-corto .owl-wrapper").css("width", "500px");
      break;
    }
  </script>
</body>

</html>