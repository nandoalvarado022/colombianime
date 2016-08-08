 
<link rel="stylesheet" href="http://www.elheraldo.co/sites/default/themes/eh/social_buttons/social_buttons.css">
<style>

@media screen and (max-width: 800px) {

/*============================================================================
  Social Icon Buttons
  
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
.social-sharing a{float: right; display: inline-block; color: #fff; border-radius: 2px; margin: 0 10px 10px 0; height: 22px; line-height: 22px; text-decoration: none; font-weight: normal;}
.social-sharing a:hover{color: #fff;}
.social-sharing span{display: inline-block; vertical-align: top; height: 22px; font: 8px/22px "Open Sans"; color:#fff; padding-left: 9px}
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
.share-count{position: relative; background-color: white; padding: 0 8px; margin-right: -2px; font-size: 14px; line-height: 20px; color: #333; border-radius: 0 2px 2px 0; border: 1px solid #ececec; opacity: 0; -webkit-transition: opacity 0.2s ease-in; -moz-transition: opacity 0.2s ease-in; -o-transition: opacity 0.2s ease-in; transition: opacity 0.2s ease-in;}
.share-count.is-loaded{opacity: 1; color:#333;}
.share-count:before, .share-count:after {content: ''; display: block; position: absolute; top: 50%; margin-top: -6px; width: 0; height: 0; border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-right: 6px solid;}
.share-count:before{left: -6px; border-right-color: #ececec;}
.share-count:after{left: -5px; border-right-color: white;}
a:hover .share-count{background-color: whitesmoke;}
a:hover .share-count:after{border-right-color: whitesmoke;}
.is-large .share-count{font-size: 18px; padding: 0 14px;}
/*================ Clean Buttons ================*/
.social-sharing.is-clean a{background-color: #fff; border: 1px solid #ececec; color: #333; height: 30px; line-height: 30px;}
.social-sharing.is-clean a span{height: 30px; line-height: 30px; font-size: 13px;}
.social-sharing.is-clean a:hover{background-color: #ececec;}
.social-sharing.is-clean a:hover .share-count{background-color: white;}
.social-sharing.is-clean a:hover .share-count:after{border-right-color: white;}
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
<div class="social-sharing" data-permalink="<?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>">
   <!-- compartir google + -->
  <a target="_blank" href="http://plus.google.com/share?url=<?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>" class="share-google">
    <span class="icon icon-google"></span>
    <span class="share-count">+1</span>
  </a>
  <!-- compartir twiter -->
  <span class="tituloArticuloH" style="display:none"><?php print $title ?></span> 
  <span class="urlLarga" style="display:none"><?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?></span> 
  <a target="_blank" href="http://twitter.com/share?url=<?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>&amp;text=<?php print $title ?>" class="share-twitter" style="cursor:pointer" >
 
    <span class="icon icon-twitter"></span>
    <span class="share-title">Tweet</span>
    <span class="share-count">0</span>
  
  </a>
  <!-- compartir facebook -->
  <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php print 'http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']; ?>" class="share-facebook">
    <span class="icon icon-facebook"></span>
    <span class="share-title">Compartir</span>
    <span class="share-count">0</span>
  </a>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://www.elheraldo.co/sites/default/themes/eh/social_buttons/social_buttons.js"></script>


