<script>console.log("nan2");</script>
<div id="container" class="clearfix">

  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div>

  <header id="header" role="banner" class="clearfix">
  <!--
  <?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>
    <?php if ($site_name || $site_slogan): ?>
      <hgroup id="site-name-slogan">
        <?php if ($site_name): ?>
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><span><?php print $site_name; ?></span></a>
          </h1>
        <?php endif; ?>
        <?php if ($site_slogan): ?>
          <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
        <?php endif; ?>
      </hgroup>
    <?php endif; ?>
    -->

    <?php print render($page['header']); ?>
    <?php print render($page['header_ruta']); ?>

    <div class="block_info_ruta">
      <div class="info">
        <h2 class="title">
          <span class="prex">La ruta</span>
          Turistica
        </h2>
        <p>
          En este sitio, inagurado en noviembre de 2014, trasladaron a los vendedores que invadian a los vendedores que invadian
          el frente del antiguo Sanandresito.
        </p>
        <span class="autor">Jose Tapias Araujo</span>
        <span class="detalle_autor">Universitario</span>
      </div>

      <div class="multimedia"></div>

    </div>

    <?php if ($main_menu || $secondary_menu || !empty($page['navigation'])): ?>
      <nav id="navigation" role="navigation" class="clearfix" style="display:none;">
        <?php if (!empty($page['navigation'])): ?> <!--if block in navigation region, override $main_menu and $secondary_menu-->
          <?php print render($page['navigation']); ?>
        <?php endif; ?>
        <?php if (empty($page['navigation'])): ?>
        <?php print theme('links__system_main_menu', array(
            'links' => $main_menu,
            'attributes' => array(
              'id' => 'main-menu',
              'class' => array('links', 'clearfix'),
            ),
            'heading' => array(
              'text' => t('Main menu'),
              'level' => 'h2',
              'class' => array('element-invisible'),
            ),
          )); ?>
        <?php print theme('links__system_secondary_menu', array(
            'links' => $secondary_menu,
            'attributes' => array(
              'id' => 'secondary-menu',
              'class' => array('links', 'clearfix'),
            ),
            'heading' => array(
              'text' => t('Secondary menu'),
              'level' => 'h2',
              'class' => array('element-invisible'),
            ),
          )); ?>
        <?php endif; ?>
      </nav> <!-- /#navigation -->
    <?php endif; ?>
    <?php if ($breadcrumb): print $breadcrumb; endif;?>
  </header> <!-- /#header -->

  <section id="main" role="main" class="clearfix">
    <div class="barra_amarilla">
      <ul>
        <li>
          Descubre tu ciudad
        </li>
        <li>
          Ruta Turistica
        </li>
        <li>
          Ruta del Rio
        </li>
        <li>          
          Ruta Religiosa
        </li>
        <li>
          Ruta Industrial
        </li>
      </ul>
    </div>
    <?php print $messages; ?>
    <a id="main-content"></a>
    <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
    <?php print render($page['help']); ?>
    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
    <?php //print render($page['content']); ?>
    <?php print render($page['map_rutas_all']); ?>

    <?php if ($page['sidebar_second']): ?>
      <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>
  </section> <!-- /#main -->
  

  <footer id="footer" role="contentinfo" class="clearfix">
    <?php print render($page['footer']) ?>
    <?php print $feed_icons ?>
  </footer> <!-- /#footer -->

</div> <!-- /#container -->