jQuery(document).ready(function(){

    var scripts = document.getElementsByTagName("script");

    var jsFolder = "";

    for (var i= 0; i< scripts.length; i++)

    {

        if( scripts[i].src && scripts[i].src.match(/initaudioplayer-1\.js/i))

            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);

    }

    jQuery("#amazingaudioplayer-1").amazingaudioplayer({

        jsfolder:jsFolder,

        skinsfoldername:"",

        titleinbarwidthmode:"fixed",

        timeformatlive:"%CURRENT% / LIVE",

        volumeimagewidth:24,

        barbackgroundimage:"",

        tracklistarrowimageheight:16,

        showtime:true,

        titleinbarwidth:80,

        showprogress:true,

        random:true,

        titleformat:"%TITLE%",

        height:600,

        loadingformat:"Loading...",

        prevnextimage:"prevnext-24-24-0.png",

        showinfo:false,

        imageheight:100,

        skin:"Bar",

        loopimage:"loop-24-24-0.png",

        loopimagewidth:24,

        showstop:false,

        prevnextimageheight:24,

        infoformat:"By %ARTIST% %ALBUM%<br />%INFO%",

        showloading:false,

        volumebarheight:80,

        tracklistarrowimagewidth:48,

        imagefullwidth:false,

        skinsfoldername:"",

        width:300,

        showimage:false,

        showtracklist:false,

        volumeimage:"volume-24-24-0.png",

        playpauseimagewidth:24,

        loopimageheight:24,

        tracklistitemformat:"%ID%. %TITLE% <span style='position:absolute;top:0;right:0;'>%DURATION%</span>",

        prevnextimagewidth:24,

        tracklistarrowimage:"tracklistarrow-48-16-0.png",

        playpauseimageheight:24,

        showbackgroundimage:false,

        imagewidth:100,

        stopimage:"stop-24-24-0.png",

        showvolume:true,

        playpauseimage:"playpause-24-24-0.png",

        showprevnext:true,

        backgroundimage:"",

        volumebarpadding:8,

        progressheight:8,

        showtracklistbackgroundimage:false,

        showtitle:false,

        showtitleinbar:false,

        heightmode:"auto",

        titleinbarformat:"%TITLE%",

        stopimageheight:24,

        stopimagewidth:24,

        fullwidth:false,

        tracklistbackgroundimage:"",

        showloop:true,

        showbarbackgroundimage:false,

        volumeimageheight:24,

        timeformat:"%CURRENT% / %DURATION%",

        autoplay:true,

        showvolumebar:true,

        loop:1,

        tracklistitem:10

    });

});