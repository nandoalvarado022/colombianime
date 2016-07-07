<style>
  .block_info_ruta{width: 1000px;margin: 0 auto;}
  .block_info_ruta > div{display: inline-block;}
  .block_info_ruta div.info{vertical-align: top;width: 500px;}
  .block_info_ruta div.multimedia{width: 490px;}
  .block_info_ruta img{width: 100%;height: auto;}
  .sidebar-second-fixed{position: fixed !important; right: 200px !important;}

  .view-display-id-block_1{
  width: 320px;
  float: left;
  display: inline-block;
  margin: 0;
  padding: 0;
  margin-right: 30px;
  margin-top: 30px;
  }
  .region-header-ruta{
  width: 1000px;
  margin: 0 auto;
  }
  .view-display-id-block_1 .views-field-name span:nth-child(1){
  font-size: 35px;
  display: block;
  margin: 0;
  padding: 0;
  line-height: 40px;
  color: #808080;
  }
  .view-display-id-block_1 .views-field-name span:nth-child(2){
  font-size: 65px;
  margin: 0;
  padding: 0;
  line-height: 35px;
  font-weight: bold;
  }
  .views-field-field-frase-del-autor{
  font-family: 'Jaldi', sans-serif;
  line-height: 24px;
  margin-top: 20px;
  color: #A7A7A7;
  margin-bottom: 20px;
  font-size: 20px;
  }
  .views-field-field-autor-rutas{
  text-align: right;
  font-family: 'Anton', sans-serif;
  color: #b21117;
  font-size: 20px;
  }
  .views-field-field-descripci-n-autor-rutas{
  text-align: right;
  }
  .down .left{
  width: 650px;
  float: left;
  margin-right: 30px;
  display: inline-block;
  margin-bottom: 50px;
  }
  .down{
  margin-top: 20px;
  position: relative;
  }
</style>
<div id="container" class="clearfix">
  <header id="header" role="banner" class="clearfix">
    <?php print render($page['header']); ?>
    <?php print render($page['header_ruta']); ?>
    
    <div style="display:none;">
    <?php $view = views_get_view('detalle_ruta_tax'); print $view->preview('block_2'); ?>
    </div>
  </header> <!-- /#header -->
  <section id="main" role="main" class="clearfix">
    <!-- main -->
      <?php print render($page['main_ruta']); ?>

      <div class="down">
        <!-- /sidebar-second -->
          <?php if ($page['sidebar_second_rutas']): ?>
            <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
              <?php print render($page['sidebar_second_rutas']); ?>
            </aside>
          <?php endif; ?>

        <div class="left"><?php $view = views_get_view('detalle_ruta_tax'); print $view->preview('block_4'); ?></div>
      </div>

  </section> <!-- /#main -->
  <footer id="footer" role="contentinfo" class="clearfix">
    <?php print render($page['footer']) ?>
  </footer> <!-- /#footer -->
</div> <!-- /#container -->
<script>

$(document).ready(function(){  
  show_sitios_map("parques");
  var menu = $('#sidebar-second');
  var menu_offset = $('.down').offset();
  $(window).on('scroll', function() {
    if($(window).scrollTop() > menu_offset.top) {
      menu.addClass('sidebar-second-fixed');
      } else {
      menu.removeClass('sidebar-second-fixed');
    }
  });
});
</script>

<style>
  #sidebar-second{top: 0px !important;}
</style>