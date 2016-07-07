<!doctype html>
<html>
<head>
	<meta charset="utf-8">
  <link href='/files/tip_cards/css/tip_cards.css' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="/files/tip_cards/js/jquery.tip_cards.js"></script>
  <!--<link rel="stylesheet" type="text/css" href="/files/tip_cards/css/estilos.css">-->
  
  <script>
	  $(document).ready( function() {
	    $(document).ready( function() {
  	    $(".tips").tip_cards();
  	  });
	  });
	</script>
</head>
<body>
  <?php //$view = views_get_view('calendario_contenido'); print $view->preview('block_1'); ?>
  <?php //$view = views_get_view('frontpage'); print $view->preview('block_2'); ?>
  <div class="wrapper">
    <div class="main">
      <div class="page-container">
        <ul class="tips">
          <li>
            <div class="tc_front">
            	<a href="#tip1">Cartagena con todo incluido</a>
            </div>
            <div class="tc_back"></div>

            <div id="tip1" class="tip">
              <div class="tc_front">
                <h1>Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</h1>
                <p>2 Dic</p>
              </div>
              <div class="tc_back">
                <p>Tip 1: Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</p>
              </div>
            </div>
          </li>

          <li>
            <div class="tc_front">
              <a href="#tip1">Cartagena con todo incluido</a>
            </div>
            <div class="tc_back"></div>

            <div id="tip1" class="tip">
              <div class="tc_front">
                <h1>Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</h1>
                <p>2 Dic</p>
              </div>
              <div class="tc_back">
                <p>Tip 1: Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</p>
              </div>
            </div>
          </li>

          <li>
            <div class="tc_front">
              <a href="#tip1">Cartagena con todo incluido</a>
            </div>
            <div class="tc_back"></div>

            <div id="tip1" class="tip">
              <div class="tc_front">
                <h1>Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</h1>
                <p>2 Dic</p>
              </div>
              <div class="tc_back">
                <p>Tip 1: Disfruta de las mejores playas de colombia este mes de diciembre 4:00pm</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>