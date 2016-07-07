<style>
.social-sharing span{border-radius: 5px !important;}
.social-sharing a{border-radius: 10px 5px 5px 10px !important;}

@media screen and (max-width: 800px) {

/*============================================================================
  Social Icon Buttons
  Author:
  Alan Sierra barbosa
==============================================================================*/
[class^="icon-"], [class*=" icon-"] {font-family: 'icons'; speak: none; font-style: normal; font-weight: normal; font-variant: normal; text-transform: none; line-height: 1; /* Better Font Rendering =========== */ -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;}
.icon-fancy:before{content: "\46";}
.icon-twitter:before{content: "\54";}
.icon-facebook:before{content: "\66";}
.icon-google:before{content: "\67";}
.icon-pinterest:before{content: "\70";}
/*================ Social share buttons ================*/
.social-sharing{height: 22px;  margin-top: 0; display: inline-block;}
.social-sharing *{-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
.social-sharing a{float: right; display: inline-block; color: #fff; border-radius: 5px; margin: 0 10px 10px 0; height: 22px; line-height: 22px; text-decoration: none; font-weight: normal;}
.social-sharing a:hover{color: #fff;}
.social-sharing span{display: inline-block; vertical-align: top; font: 8px/22px "Open Sans"; color:#fff; padding-left: 9px;border-radius: 5px;}
.social-sharing .icon{padding: 0 5px 0 10px;}
.social-sharing .icon:before{line-height: 22px;}
.social-sharing.is-large a{height: 44px; line-height: 44px;}
.social-sharing.is-large a span{height: 44px; line-height: 44px; font-size: 18px;}
.social-sharing.is-large a .icon{padding: 0 10px 0 18px;}
.social-sharing.is-large a .icon:before{line-height: 44px;}
.share-title{font-weight: 800; font-size: 12px; padding-right: 10px;}
.is-large .share-title{padding-right: 16px;}
.share-facebook{background-color: #3b5998;}
.share-facebook:hover{background-color: #2d4373;}
.share-twitter{background-color: #00aced;}
.share-twitter:hover{background-color: #0087ba;}
.share-pinterest{background-color: #cb2027;}
.share-pinterest:hover{background-color: #9f191f;}
.share-fancy{background-color: #4999dc;}
.share-fancy:hover{background-color: #2780cb;}
.share-google{background-color: #dd4b39;}
.share-google:hover{background-color: #c23321;}
.share-count{position: relative; background-color: white; padding: 0 8px; margin-right: -2px; font-size: 14px; line-height: 20px; color: #fff; border-radius: 0 2px 2px 0; border: 1px solid #ececec; opacity: 0; -webkit-transition: opacity 0.2s ease-in; -moz-transition: opacity 0.2s ease-in; -o-transition: opacity 0.2s ease-in; transition: opacity 0.2s ease-in;}
.share-count.is-loaded{opacity: 1; color:#333;}
.share-count:before, .share-count:after {content: ''; display: block; position: absolute; top: 50%; margin-top: -6px; width: 0; height: 0; border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-right: 6px solid;}
.share-count:before{left: -6px; border-right-color: #ececec;}
.share-count:after{left: -5px; border-right-color: white;}
.is-large .share-count{font-size: 18px; padding: 0 14px;}
/*================ Clean Buttons ================*/
.social-sharing.is-clean a{background-color: #fff; border: 1px solid #ececec; color: #333; height: 30px; line-height: 30px;}
.social-sharing.is-clean a span{height: 30px; line-height: 30px; font-size: 13px;}
.social-sharing.is-clean a .share-title{font-weight: normal;}
.social-sharing.is-clean .share-count{top: -1px;}
.icon-facebook {background: url('http://www.elheraldo.co/sites/default/themes/eh/social_buttons/facebook.png') no-repeat 10px center / 15px auto transparent; width: 30px; font-size: 0px !important;}
.icon-twitter {background: url('http://www.elheraldo.co/sites/default/themes/eh/social_buttons/twitter.png') no-repeat 10px center / 15px auto transparent; width: 30px; font-size: 0px !important;}
.icon-google {background: url('http://www.elheraldo.co/sites/default/themes/eh/social_buttons/google.png') no-repeat 10px center / 15px auto transparent; width: 30px; font-size: 0px !important;}

}

@media screen and (max-width: 320px) {
.share-facebook{width: auto;}
.share-twitter{width: auto;}
.social-sharing span {font: 5px/22px "Open Sans";}
.social-sharing a{margin: 0 2px 10px 0;}
.social-sharing span {padding-left: 2px;}

}

</style>
<?php $url='http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];?>
<div class="social-sharing" data-permalink="<?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>">
   <!-- compartir google + -->
  <a target="_blank" href="http://plus.google.com/share?url=<?php print $url;?>" class="share-google">
    <span class="icon icon-google"></span>
    <span class="share-count">+1</span>
  </a>
  <!-- compartir twiter -->
  <span class="tituloArticuloH" style="display:none"><?php echo $title="Colombianime"; ?></span> <!-- se usa en el script-->
  <span class="urlLarga" style="display:none"><?php echo $url; ?></span> <!-- se usa en el script-->
  <a target="_blank" href="http://twitter.com/share?url=<?php print $url; ?>&amp;text=<?php echo $title;?>" class="share-twitter" style="cursor:pointer" >
 
    <span class="icon icon-twitter"></span>
    <span class="share-title"></span>
    <span class="share-count">0</span>
  
  </a>
  <!-- compartir facebook -->
  <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php print $url; ?>" class="share-facebook">
    <span class="icon icon-facebook"></span>
    <span class="share-title"></span>
    <span class="share-count">0</span>
  </a>
</div>

<script>
/*============================================================================
  Social Icon Buttons v1.0
  Author:
    Carson Shold | @cshold
    http://www.carsonshold.com
  MIT License
==============================================================================*/
window.CSbuttons = window.CSbuttons || {};

CSbuttons.cache = {
  shareButtons: $('.social-sharing')
}

CSbuttons.init = function () {
  CSbuttons.socialSharing();
}

CSbuttons.socialSharing = function () {
  var buttons = CSbuttons.cache.shareButtons,
      permalink = buttons.attr('data-permalink'),
      shareLinks = buttons.find('a').addClass('tester'),
      socialCounts = buttons.find('span.share-count');

  // Get share stats from respective APIs
  var fbLink = $('.share-facebook'),
      twitLink = $('.share-twitter'),
      pinLink = $('.share-pinterest'),
      googleLink = $('.share-google');

  if ( fbLink.length ) {
  $.ajax({
            type: "GET",
            url: "https://api.facebook.com/method/links.getStats?urls=" + permalink + "&format=json",
            dataType: "jsonp",
            cache: false,
            crossDomain: true,
            context: document.body,
            contentType: "application/json; charset=utf-8",
            success: function(g) {
         if (g[0].share_count) {
                    fbLink.find('.share-count').text(g[0].share_count).addClass('is-loaded');
                } else {
           fbLink.find('.share-count').remove();
                      
                }
             
            }
        });
  
 
  };

  if ( twitLink.length ) {
    $.getJSON('https://cdn.api.twitter.com/1/urls/count.json?url=' + permalink + '&callback=?', function(data) {
      if (data.count > 0) {
        twitLink.find('.share-count').text(data.count).addClass('is-loaded');
      } else {
        twitLink.find('.share-count').remove();
      }
    });
  };

  

  if ( googleLink.length ) {
    // Can't currently get Google+ count with JS, so just pretend it loaded
    googleLink.find('.share-count').addClass('is-loaded');
  }

  // Share popups
  shareLinks.on('click', function(e) {
  titulo = $(".tituloArticuloH").html();
  long_url = $(".urlLarga").html();
  
  var el = $(this),
        popup = el.attr('class').replace('-','_'),
        link = el.attr('href'),
        w = 700,
        h = 400;
     
  e.preventDefault();
    
    // Set popup sizes
    switch (popup) {
    case 'share_twitter tester':
       link=getData(long_url, titulo);     
     h = 300;
       break;
      case 'share_fancy tester':
      w = 480;
        h = 720;
        break;
    case 'share_facebook tester':
    w = 576;
    break;
      case 'share_google tester':
      w = 500;
        break;
    }
   
    window.open(link, popup, 'width=' + w + ', height=' + h);
  
  });
}
function getData(long_url,titulo) {
  var result;
  var request = $.ajax({ 
      url: "http://api.bit.ly/v3/shorten", 
      dataType: 'json', 
      data: {longUrl:long_url,apiKey:"R_0b6d205772ef40b4a0a6241dba8a0bdc",login:"o_33s5u6mlbu"}, 
      async: false, 
      success: function(response){ 
        $(".share-twitter.tester").attr("href", 'http://twitter.com/share?url=' + response.data.url + '&via=@colombianime&amp;text=' + titulo);
        result = 'http://twitter.com/share?url=' + response.data.url + '&via=@colombianime&amp;text=' + titulo;
      } 
    });
 return result;
}
  
$(function() {
  window.CSbuttons.init();
});
</script>