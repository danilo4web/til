var current_time = 0;
var status = false;

var list_events_seconds = {};
var list_events_percent = {};
var TAG = '#destaque_video a';

var triggerEvents = {
	init : function() {},
	listenerYoutube : function (event) {
		
		switch(event) {
			case YT.PlayerState.PLAYING :
				triggerEvents.startCount();
				break;
				
			case YT.PlayerState.PAUSED || YT.PlayerState.BUFFERING:
				triggerEvents.stopCount();
				break;
				
			case YT.PlayerState.CUED :
				triggerEvents.started();
				break;
				
			default :
				triggerEvents.resetCount();
				break;		
		}
	},
	trigger_by_seconds : function(seconds){
		triggerEvents.eventoGA('Video', seconds + 'seg', $(TAG).data('label'), seconds);
	},
	trigger_by_percents : function(percent){
		triggerEvents.eventoGA('Video', percent + '%', $(TAG).data('label'), percent);
	},
	eventoGA : function(category, action, label, value) {
		if (typeof value !== "undefined") {
			console.log('Evento GA\ncategory: ' + category + '\naction: ' + action + '\nlabel: ' + label + '\nvalue: ' + value);
			ga('send', 'event', category, action, label, value);
		} else {
			console.log('Evento GA\ncategory: ' + category + '\naction: ' + action + '\nlabel: ' + label);
			ga('send', 'event', category, action, label);
		}
	},
	started : function() {
		list_events_seconds = {
			30 : 'funcao_30sec' 
		};
		
		list_events_percent = { };
	},
	verifyRules : function(seconds, percent) {
		// verify rules by second
		if(list_events_seconds[seconds]) {
			triggerEvents.trigger_by_seconds(seconds);
			delete list_events_seconds[seconds];
		}
		
		// verify rules by percent
		if(list_events_percent[percent]) {
			triggerEvents.trigger_by_percents(percent);
			delete list_events_percent[percent];
		}
		
	},
	startCount : function() {
		if(status === true) { return true; }
		
		status = setInterval(function() {
			
			current_time = player.getCurrentTime();
			percent = (current_time / player.getDuration()) * 100;
			
			triggerEvents.verifyRules(parseInt(current_time), parseInt(percent));
			
		}, 1);
	},
	stopCount : function() {
		if(status) {
			clearInterval(status);
			status = false;
		}
	},
	resetCount : function() {
		current_time = 0;
		clearInterval(status);
		status = false;
	}
}