<div id="container" class="clearfix">
  <div class="chica_chat">ChicaChat</div>
  <!-- <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div> -->

    <section id="main" role="main" class="clearfix">
      <?php include "barra_izq.tpl.php";?>  
      <div class="der">
        <div class="info_landig_page">
          <img class="principal" src="/files/images/11081427_370562649810783_119041275289544657_n.jpg" alt="">
          <img class="secundaria" src="/files/images/11065303_370562626477452_6861998346397142977_n.jpg" alt="">
          <div class="nombre">Taiyou Anime Store</div>
          <div class="datos">Direccion: Cra 11B numero 49-47 Tel. 300 7790294</div>
        </div>
        <?php $_GET["q"]="taxonomy/term/50";?>
        <?php $view = views_get_view('landing_page'); print $view->preview('block_1'); ?>
        <?php print render($content);?>
      </div>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);?>
  </section>
</div>

<style>
  h1{ text-align: center;
    color: #F49401;
    background: transparent linear-gradient(to bottom, #FFF 0%, #F2F2F2 100%) repeat scroll 0% 0%;}
    .field-label{display: none;}
  .info_landig_page{position: relative;height: 350px;}
  .info_landig_page img.principal{max-width: 100%;}
  .info_landig_page img.secundaria{position: absolute;
    bottom: 25px;
    max-width: 90px;
    left: 0px;
    border-radius: 50%;}
  .info_landig_page .nombre{font-family: 'Titan One', cursive;
    font-size: 2em;
    margin-left: 99px;}
  .info_landig_page .datos{    margin: -10px 0 0 100px;
    color: #5D5D5D;
    font-size: 20px;}

    @media screen and (max-width: 480px) {
      .info_landig_page{margin-bottom: 20px;}
      .info_landig_page .nombre{font-size: 1.5em;}
      .info_landig_page{height: 250px;}
      .info_landig_page .datos{margin-left: 100px;}
    }
</style>