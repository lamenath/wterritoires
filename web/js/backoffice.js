var oo = {
	
	checkMedia: function() 
	{
		if($('media_type').value == 'photo')
		{
			$('media_file').parentNode.parentNode.parentNode.style.display = '';
			$('media_embed').parentNode.parentNode.parentNode.style.display = 'none';
		}
		else
		{
			$('media_file').parentNode.parentNode.parentNode.style.display = 'none';
			$('media_embed').parentNode.parentNode.parentNode.style.display = '';
		}
	},
	
	onDOMReady: function(handler)
	{
		if (document.addEventListener) {
			if (navigator.userAgent.indexOf('AppleWebKit/') > -1 || window.opera){
			var timer = window.setInterval(function() {
			if (/loaded|complete/.test(document.readyState)){
				window.clearInterval(timer);
				handler();
			 }
		 }, 30);
			
		 }
			else document.addEventListener('DOMContentLoaded', handler, false);
		 }else{
		 var tempNode = document.createElement('document:ready');
		 (function(){
		 try {
		 if(document.readyState != 'complete')
		 return setTimeout(arguments.callee, 30);
		 tempNode.doScroll('left');
		 tempNode = null;
		 handler();
		 }catch (e){
		 setTimeout(arguments.callee, 30);
		 }
		 })()
		 }
	 },
	 
}

oo.onDOMReady( function() { oo.checkMedia();
Event.observe($('media_type'), 'change', oo.checkMedia); } );