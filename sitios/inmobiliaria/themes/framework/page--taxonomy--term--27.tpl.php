  <?php
    $og_title = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:title',
    'content' => "Feria Inmobiliaria",
    ),
    );
    drupal_add_html_head($og_title, 'og_title');

    $og_url = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:url',
    'content' => 'http://especiales.elheraldo.co/feriainmobiliaria/',
    ),
    );
    drupal_add_html_head($og_url, 'og_url');

    $element = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:image',
    'content' => "",
    ),
    );
    drupal_add_html_head($element, 'og_image');

    $og_description = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'property' => 'og:description',
    'content' => "El evento que tiene las mejores ofertas inmobiliarias de la Costa. Decenas de proyectos de vivienda e inversión, oportunidades de financiación e información de interés sólo a un click de distancia.",
    ),
    );
    drupal_add_html_head($og_description, 'og_description');
  ?>
    <div class="slider-block">
    <?php $slug=str_replace(" ", "-", $title);?>
    <div class="encabezado">
      <div class="left">
        <h3>
          <span class="triangulo"></span>
          Sobre Nosotros
        </h3>

        <div>
          <?php $view = views_get_view('sobre_nosotros'); print $view->preview('block_1'); ?>
        </div>

        <p class="texto">
          Revista Área Caribe de EL HERALDO con toda la oferta inmobiliaria de la región Caribe de Colombia. Cada mes encuentra la revista gratis en la web areacaribe.com.co, puntos de venta EL HERALDO en toda la Costa, tiendas de decoración y almacenes de muebles.
          Los suscriptores del periódico EL HERALDO la recibirán de forma gratuita los primeros días de cada mes.

          En cada edición Área Caribe te mostrará las diferentes opciones de inversión en vivienda, tips sobre negociación en compra y venta, de decoración, diseño y distribución de tus espacios.
        </p>
      </div>
    </div>

    <div class="cuerpo">
    </div>

    </div>
  </div><!-- back container -->
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300);
    @import url(https://fonts.googleapis.com/css?family=Jaldi:400,700);
    @import url(https://fonts.googleapis.com/css?family=Dosis:400,300);
     .cuerpo .title{
      font-weight: bold;
      font-size: 20px;
      margin-top: 30px;
    }
    .encabezado .left .texto {
        color: #19476f;
        padding: 50px 30px 50px 30px;
        margin: 0px 190px;
        font-size: 1.1em;
        text-align: justify;
        background: #FFF;
        border-radius: 6px 6px 0 0;
    }
    .encabezado .left .texto:before {
        content: " ";
        display: block;
        height: 6px;
        width: 100%;
        background: #049ed4;
        margin: -41px 0 40px;
        border-radius: 8px;
    }
     .encabezado .left h1{
    color: #fff;
    display: inline-block;
    margin-left: 30px;
    margin-top: 5px;
    font-family: 'Dosis', sans-serif;
    }
     .encabezado .left h3 .triangulo{
    width: 0;
    height: 0;
    border-bottom: 20px solid #007DBD;
    border-left: 20px solid transparent;
    position: absolute;
    left: 0px;
    top: -20px;
    }
     .encabezado .left h3{
    width: 460px;
    display: inline-block;
    color: #fff;
    font-family: 'Dosis', sans-serif;
    padding: 0 10px;
    margin: 30px 0 0 -20px;
    font-weight: lighter;
    position: relative;
    text-transform: uppercase;
    padding: 10px 15px 10px 50px;
    font-size: 35px;
    letter-spacing: 2px;
    width: 2 background: rgba(0,159,215,1);
    background: -moz-linear-gradient(left, rgba(0,159,215,1) 0%, rgba(0,39,56,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,159,215,1)), color-stop(100%, rgba(0,39,56,1)));
    background: -webkit-linear-gradient(left, rgba(0,159,215,1) 0%, rgba(0,39,56,1) 100%);
    background: -o-linear-gradient(left, rgba(0,159,215,1) 0%, rgba(0,39,56,1) 100%);
    background: -ms-linear-gradient(left, rgba(0,159,215,1) 0%, rgba(0,39,56,1) 100%);
    background: linear-gradient(to right, rgba(0,159,215,1) 0%, rgba(0,39,56,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#009fd7', endColorstr='#002738', GradientType=1 );
    }
     .encabezado .left{
      background: #002738;
      margin-top: -7px;
      border-radius: 0 0 6px 6px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    h2.titulo-proyectos {
      margin: 0px;
      background: transparent linear-gradient(to bottom, #FFF 0%, #F6F6F6 100%) repeat scroll 0% 0%;
    }
    .fecha_entrega, .fecha_entrega_label {
      font: 600 15px/24px 'Open Sans', sans-serif;
      color: #29ABE2;
      background-color: rgba(204, 204, 204, 0.13);
      padding: 12px 15px 15px 15px;
      width: 270px;
      display: inline-block;
    } 
    .view-id-general_tipos_contenido .views-field-field-sumario .field-content{
      color: #808080;
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
    }
    .view-id-general_tipos_contenido .views-field-created{
      font-size: 13px;
    }
    .view-id-general_tipos_contenido{
      display: inline-block;
    }
    .view-id-general_tipos_contenido .views-field-field-sumario,.view-id-general_tipos_contenido .views-field-created{
      padding: 10px;
    }
    #main-home .content{width:1000px;margin: 0 auto;height: 100px;}

    #main-home{width: 100%; margin: 0 auto;}
    #site-name{display: none;}
    h1.title{display: none;}
    #breadcrumb{display: none;}
    .messages{display: none;}
    .body.sidebar-first #main{float: none !important;}
    #sidebar-first{display: none;}
    .slider-block .encabezado{
      background: #fff;
    }
    @media screen and (max-width: 480px){
      a.constructoras{
        display: none;
      }
    body .paginadores-corto{
      display: none;
    }
    #footer .contenedor{
      width: 320px;
    }
    .slider-block .encabezado{
      width: 100%;
    }
    body .te-quedaste-corto{
      width: 90%;
    }
    body .box-tittle {
      width: 100%;
    }
    body .sombra-title {
    display: none;
    }
    body .view-display-id-block_4 {
    width: 100%;
    padding: 0px;
    height: 1050px;
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
    transition: all 0.9s ease-in-out;
    -webkit-transition: all 0.9s ease-in-out;
    -moz-transition: all 0.9s ease-in-out;
    -o-transition: all 0.9s ease-in-out;
    -ms-transition: all 0.9s ease-in-out;
    }
    body ul.menu-feria {
    width: 100%;
    border: none;
    top: 20px;
    }
    body .view-display-id-block_4 .view-content {
      width: 100%;
    }
    body .view-display-id-block_4 .views-row {
      width: 94%;
      float: none;
      text-align: center;
      margin-right: 0px;
    }
    .slider-block{width:auto;}
    .logo-feria{background-size: 100%;}
    .redes-sociales{float:none;display: block;text-align: center;}
    .section-logos{height: 160px;}
    .back-container {/*max-height: 580px; */height: auto;}
    .te-quedaste-corto{width:auto;}
    .box-tittle{width:auto;}
    body.sidebar-first #main{width: 320px;overflow: hidden;}
    #main-home{width: 320px;margin: 0 auto;overflow: hidden;}


    .back-container-two{padding: 10px 0px;margin-top: 20px;}
    }
  </style>
  

  <?php //include("http://especiales.elheraldo.co/feriainmobiliaria/themes/framework%205/tpl/footer.tpl.php");?>
  <?php //include("footer.tpl.php");?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script>
  //Añadiendo el menor que, y mayor que de las etiquetas
  var obj=$(".view-id-general_taxonomy.view-display-id-block_n1").html();
  obj=obj.replace("&lt;", "<");
  obj=obj.replace("&lt;", "<");
  obj=obj.replace("&gt;", ">");
  obj=obj.replace("&gt;", ">");
  $(".view-id-general_taxonomy.view-display-id-block_n1").html(obj);

  var obj=$(".view-id-general_taxonomy.view-display-id-block_n2").html();
  obj=obj.replace("&lt;", "<");
  obj=obj.replace("&lt;", "<");
  obj=obj.replace("&gt;", ">");
  obj=obj.replace("&gt;", ">");
  $(".view-id-general_taxonomy.view-display-id-block_n2").html(obj);

  $(function() {
    /*Selected al primer hijo de slider*/
    /*Footer*/
    $(".view-display-id-block_4 .views-row").mouseover(function(){
    $(this).find(".info_especial").css({opacity:"1"});
    });
    $(".view-display-id-block_4 .views-row").mouseleave(function(){
    $(this).find(".info_especial").css({opacity:"0"});
    });

    for (var i = 2; i < 100; i++) {
      $(".datos .views-row-"+i).hide();
    };
  });

  function enviar_datos(){
    datos=$("[name=form-01]").serialize();
    //alert(datos);
    $.ajax({
      url:"../ajax/contactanos.php",
      data:datos,
      type:"POST",
      success:function(res){
        alert(res);
      }
    });
  }
</script>