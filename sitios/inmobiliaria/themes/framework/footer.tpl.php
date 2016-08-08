<div class="back-container-two">
  <div class="te-quedaste-corto">
    <div class="box-tittle"><h2 style="width:300px;">¿Te quedaste corto?</h2></div>
    <div class="sombra-title"></div>
    <div class="contenedor">
      <?php $currentterm = "";
      $view = views_get_view('frontpage'); print $view->preview('block_4'); ?>
      <div class="paginadores-corto">
        <div class="pag-corto-left"></div>
        <div class="pag-corto-right"></div>
      </div>
    </div>
  </div>
</div>

<style>
  .back-container-two{
  width: 100%;
  background: -moz-linear-gradient(left, rgba(54,54,54,1) 0%, rgba(77,76,77,1) 52%, rgba(54,54,54,1) 100%);;
  background: -webkit-linear-gradient(left, rgba(54,54,54,1) 0%, rgba(77,76,77,1) 52%, rgba(54,54,54,1) 100%);;
  padding: 50px 0px;
  }
  .te-quedaste-corto{
  width: 1000px;
  margin: 0 auto;
  }
  .te-quedaste-corto .contenedor{
  position: relative;
  }
  .sombra-title{
      background: url(http://especiales.elheraldo.co/feriainmobiliaria/themes/framework%205/images/sombra-title.png) no-repeat 100% 0;
      height: 23px;
      width: 100%;
      margin-top: -43px;
      padding-bottom: 28px;
    }
  #main-home .te-quedaste-corto{ width: 100%; background-color: #6E6F73;overflow: hidden;}
  #main-home .te-quedaste-corto .contenedor{ width: 1000px; height: 390px; overflow: hidden; margin:40px auto 0; text-align: center;}
  #main-home .te-quedaste-corto .contenedor .views-row{ background-color: #fff; display: inline-block; width: 205px; margin: 0 10px; padding: 10px; text-align: left;}
  #main-home .te-quedaste-corto .contenedor .views-row img{ width: 100%; height: auto; }
  #main-home .te-quedaste-corto .contenedor .view-content{ margin-bottom: 10px;}
  #main-home .te-quedaste-corto .contenedor{ width: 320px;}
  .view-display-id-block_4 .views-row .titulo{
    color: #0073dc;
  }
  .view-display-id-block_4 .views-row .titulo a{
      font: 400 13px/15px 'Open Sans', sans-serif;
      color: #0073dc;
      text-transform: uppercase;
      line-height: 27px;
  }
  .view-display-id-block_4 .views-row .descripcion p{
    font: 400 12px/16px 'Open Sans', sans-serif;
    line-height: 19px;
    color: #333;
    margin-bottom: 6px;
  }
  .view-display-id-block_4{
    width: 900px;
    overflow: hidden;
    position: relative;
    padding: 0px 50px;
  }
  .contenedor .view-display-id-block_4 .views-row-4,.contenedor .view-display-id-block_4 .views-row-8,.contenedor .view-display-id-block_4 .views-row-12,.contenedor .view-display-id-block_4 .views-row-16{
    margin-right: 52px;
  }
  .view-display-id-block_4 .view-content{
    width: 5000px;
    position: relative;
    left: 0px;
    -webkit-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -moz-transition: all 0.4s ease-in-out;
    -ms-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
  }
  .view-display-id-block_4 .views-row{
    float: left;
    width: 200px;
    margin-right: 6px;
    display: inline-block;
    background-color: #fff;
    padding: 15px 10px;
  }
</style>

<script>
/*
$(function() {
   var x = 0;
  $(".paginadores-corto .pag-corto-right").click(function(){
    x = parseInt(x) - 950;     
    var xx = x + "px";      
    if ( ( x < -2850 ) ){        
      $(".view-display-id-block_4 .view-content").css("left","0");
      x = 0
    }else{
      $(".view-display-id-block_4 .view-content").css("left",xx);
    }
  });
  $(".paginadores-corto .pag-corto-left").click(function(){
    x = parseInt(x) + 950;      
    var xx = x + "px";     
    if ( ( x > 0 ) ){        
      $(".view-display-id-block_4 .view-content").css("left","-2850px");
      x = -2850
    }else{
      $(".view-display-id-block_4 .view-content").css("left",xx);
    }
  });
});*/
</script>