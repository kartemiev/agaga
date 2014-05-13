function ajaxasizeLinks(){
    $('.pagination ul li a').click(function(event)
 {
      event.preventDefault();
       $('#cdrview').load(event.currentTarget.href + ' #cdrview',onAjaxload);

 }
  
);
    $('.jquery_jplayer_1').click(
         function(event)
 {
            event.preventDefault(); 
/*           var isPaused = $('#jquery_jplayer_1').data().jPlayer.status.paused;*/
           $('img.playerimg').attr('src','/img/player-play.png');
/*           if (true == isPaused || 'undefined' === isPaused)
           {*/
           $('#playbox').modal('show');
           var cList = $("#callinfo");
           var title = $(event.currentTarget).data('call').split(',');
           $(cList).empty();
           $.each(title, function(i,value) {
        	    var li = $('<li/>')
        	        .appendTo(cList);
        	    $(li).text(value);
        	    
           });
             var $player = $("#jquery_jplayer_1");
 
               playSound(event.currentTarget.href,event.currentTarget);        	   
           /* }
           else 
           {
               stopSound();        	           	   
           }*/
 }
     );
    
    
}
function movePaginatorAboveTable()
{
    $('#abovetable').insertBefore('#cdrtable');
        $('#abovetable').show();
}
function onAjaxload()
{
  
  ajaxasizeLinks();
  movePaginatorAboveTable();
    
}

function playSound(sound, target) {
    var $player = $("#jquery_jplayer_1");
 
    if ($player.data().jPlayer && $player.data().jPlayer.internal.ready === true) {
          
        $player.jPlayer("setMedia", {
            mp3: sound
        }).jPlayer("play");
    }
    else {                 
        $player.jPlayer({
            ready: function() {
                $(this).jPlayer("setMedia", {
                    mp3: sound
                }).jPlayer("play");
            },
            loop: false,
            swfPath: "/js/Jplayer.swf",
            supplied: "mp3"
        });
    }
}

function stopSound()
{
  var $player = $("#jquery_jplayer_1");
  $player.jPlayer("clearMedia");
  $player.jPlayer("clearFile");

}
function initJplayer()
{
    var $player = $("#jquery_jplayer_1");     
}
$(function()
{
 onAjaxload();
 $('#playbox').on('hide', function() {
    stopSound();
 });
}
);

