<!-- slider nuevo -->
  <?php $view = views_get_view('frontpage'); print $view->preview('block_1');?>
  <!-- Owl Carousel Assets -->
  <script src="/themes/framework/assets/js/jquery-1.9.1.min.js"></script> 
  <link href="/themes/framework/owl-carousel/owl.carousel.css" rel="stylesheet">
  <link href="/themes/framework/owl-carousel/owl.theme.css" rel="stylesheet">

  <div id="demo">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div id="owl-demo" class="owl-carousel">
              <div class="item"><img src="/themes/framework/assets/fullimage1.jpg" alt="The Last of us"></div>
              <div class="item"><img src="/themes/framework/assets/fullimage2.jpg" alt="GTA V"></div>
              <div class="item"><img src="/themes/framework/assets/fullimage3.jpg" alt="Mirror Edge"></div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <script src="/themes/framework/owl-carousel/owl.carousel.js"></script>
  <script>
    $(function() {
      $("#owl-demo").owlCarousel({
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true
        // "singleItem:true" is a shortcut for:
        // items : 1, 
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false
      });
    });
  </script>

  
  <!-- Demo -->
  <style>
  #owl-demo .item img{
      display: block;
      width: 100%;
      height: auto;
  }
  </style>

  <script>
  $(function() {
    $("#owl-demo").owlCarousel({

    navigation : true,
    slideSpeed : 300,
    paginationSpeed : 400,
    singleItem : true

    // "singleItem:true" is a shortcut for:
    // items : 1, 
    // itemsDesktop : false,
    // itemsDesktopSmall : false,
    // itemsTablet: false,
    // itemsMobile : false

    });
  });
  </script>
<!-- slider nuevo -->