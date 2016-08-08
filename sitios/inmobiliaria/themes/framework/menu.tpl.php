<div class="slider-block">
  <header id="header" role="banner" class="clearfix">
    <?php print render($page['header']); ?>

    <?php if ($main_menu || $secondary_menu || !empty($page['navigation'])): ?>
    <nav id="navigation" role="navigation" class="clearfix">
    <?php if (!empty($page['navigation'])): ?>
    <?php print render($page['navigation']); ?>
    <?php endif; ?>
    <?php if (empty($page['navigation'])): ?>
    <?php endif; ?>
    </nav> <!-- /#navigation -->
    <?php endif; ?>
    <div class="section-logos">
      <a class="logo-feria" href="http://especiales.elheraldo.co/feriainmobiliaria/"></a>
    </div>

    <div class="buscador_google">
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
    </div>

    <div class="redes-sociales">
      <?php include("social_buttons_new.tpl.php"); ?>
    </div>

  </header> <!-- /#header -->
  <div class="menu-mobile">
    <div class="menu_bar">
      <a class="bt-menu"><span class="list2"></span></a>
    </div>
  </div>

  <nav id="nav_mobile">
    <ul>
    <li><a href="/">INICIO</a></li>
    <li><a href="/secciones/listado-de-notas">NOTAS</a></li>
    <li><a href="/"  class="proyectos">PROYECTOS</a></li>
    <li><a href="/"  class="constructoras">CONSTRUCTORAS</a></li>
    <li><a href="/secciones/sobre-nosotros">Sobre nosotros</a></li>
    <li><a href="/secciones/edicion-impresa">Edicion impresa</a></li>
    </ul>
  </nav>
  <div class="container-menu">
    <ul class="menu-feria">
      <li><a href="/">INICIO</a></li>
      <li><a href="/secciones/listado-de-notas">NOTAS</a></li>
      <li><a href="/" class="proyectos">PROYECTOS</a></li>
      <li><a href="/"  class="constructoras">CONSTRUCTORAS</a></li>
      <li><a href="/secciones/sobre-nosotros">Sobre nosotros</a></li>
      <li><a href="/secciones/edicion-impresa">Edicion impresa</a></li>
    </ul>
  </div>
  <section id="slider">
    <?php $view = views_get_view('frontpage'); print $view->preview('block_1'); ?>  
    <div class="box-pager-noticias">
      <div class="pagerNoticas">
        <ul>
          <li class="item1">1</li>
          <li class="item2">2</li>
          <li class="item3">3</li>
          <li class="item4">4</li>
          <li class="item5">5</li>
        </ul>
      </div>
    </div>
    <div class="paginadores">
      <div class="pag-left"></div>
      <div class="pag-right"></div>
    </div>
  </section>
</div>