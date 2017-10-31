var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];

tag.src = "https://www.youtube.com/iframe_api";
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    events: {
      'onReady': function() { 
    	  player.cueVideoById( $(this).data('id') ); // id youtube
      },
      'onStateChange': function(event){
    	triggerEvents.listenerYoutube(event.data);
      }
    },
    playerVars: {
      'controls':0,
      'modestbranding':1,
      'showinfo':0,
      'rel':0
    }
  });
}