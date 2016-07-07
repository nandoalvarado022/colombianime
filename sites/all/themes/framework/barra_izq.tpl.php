 <div class="izq">
  <div class="item-list">
    <?php $view = views_get_view('frontpage'); print $view->preview('block_6'); ?>
  </div>

  <div class="anuncio anuncio_300x200">
    <label>Anuncio</label>
    <img src="/files/images/anuncio-publicitario-personificacion.jpg">
  </div>
  <div id="slider_derecho">
    <?php $view = views_get_view('frontpage'); print $view->preview('block_2'); ?>
  </div>
</div>