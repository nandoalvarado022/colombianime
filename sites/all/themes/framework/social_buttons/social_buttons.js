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
			  $(".share-twitter.tester").attr("href", 'http://twitter.com/share?url=' + response.data.url + '&via=diarioanime&amp;text=' + titulo);
 			  result = 'http://twitter.com/share?url=' + response.data.url + '&via=diarioanime&amp;text=' + titulo;
			} 
		});
 return result;
}
  
$(function() {
  window.CSbuttons.init();
});
