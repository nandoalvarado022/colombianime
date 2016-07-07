<div id="container" class="clearfix">

  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div>

  <header id="header" role="banner" class="clearfix">
    <?php print render($page['header']); ?>
  </header> <!-- /#header -->

  <section id="main" role="main" class="clearfix">    
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
    Eventos:
    <!-- calendario -->
    <?php include ("calendario.tpl.php");?>
    <!-- fin calendario-->
  </section> <!-- /#main -->
  

  <footer id="footer" role="contentinfo" class="clearfix">
    <?php print render($page['footer']) ?>
  </footer> <!-- /#footer -->

</div> <!-- /#container -->