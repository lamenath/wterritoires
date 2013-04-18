/**
 *
 * Copyright (c) 2009 Tony Dewan (http://www.tonydewan.com/)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.tonydewan.com/code/checkToggle/
 *   
 *   Modified for Worketer
 *   	by Simon LAMELLIERE
 * 
 */

(function($) {
	/**
	 * Version 1.0
	 * Replaces checkboxes with a toggle switch.
	 * usage: $("input[type='checkbox']").checkToggle(settings);
	 *
	 * @name  checkToggle
	 * @type  jquery
	 * @param Hash    settings					Settings
 	 * @param String  settings[on_label]		Text used for the left-side (on) label. Defaults to "On"
	 * @param String  settings[off_label]		Text used for the right-side (off) label. Defaults to "Off"
	 * @param String  settings[on_bg_color]		Hex background color for On state
	 * @param String  settings[off_bg_color]	Hex background color for Off state
	 * @param String  settings[skin_dir]		Document relative (or absolute) path to the skin directory
	 * @param Bool    settings[bypass_skin]		Flags whether to bypass the inclusion of the skin.css file.  Used if you've included the skin styles somewhere else already.
	 */

    $.fn.checkToggle = function(settings) {
   
		settings = $.extend({
			on_label	: 'Oui',
			on_bg_color	: '', 
			off_label	: 'Non',
			off_bg_color: '',
			skin_dir	: "",
			bypass_skin : false
		}, settings);
		
		function toggle(element){
			
			var checked = $(element).parent().parent().prev().attr("checked");
			
			// if it's set to on
			if(checked){
				
				$(element).parent().parent().find(".leftLabel").css("display", "none");
				$(element).animate({marginLeft: '0em'},150, 
				
				// callback function
				function(){
					$(element).parent().parent().prev().removeAttr("checked");
					$(element).parent().parent().find(".rightLabel").css("display", "");
				});
			
			}else{
			
				$(element).parent().parent().find(".rightLabel").css("display", "none");
				$(element).animate({marginLeft: '48px'}, 150, 
				
				// callback function
				function(){
					$(element).parent().parent().prev().attr("checked","checked");
					$(element).parent().parent().find(".leftLabel").css("display", "");
				});
			
			}
		
		};

		return this.each(function () {
			
			// hide the checkbox
			$(this).css('display','none');
			
			// insert the new toggle markup
			if($(this).attr("checked") != true){
				$(this).after('<div class="toggleSwitch"><span style="display:none" class="leftLabel">'+settings.on_label+'<\/span><div class="switchArea" style="background-color: '+settings.on_bg_color+'"><span class="switchHandle left" style="margin-left: 0em;"><\/span><\/div><span  class="rightLabel">'+settings.off_label+'<\/span><\div class="clear"></div><\/div>');
			}else{
				$(this).after('<div class="toggleSwitch"><span class="leftLabel">'+settings.on_label+'<\/span><div class="switchArea" style="background-color: '+settings.off_bg_color+'"><span class="switchHandle right" style="margin-left:48px"><\/span><\/div><span style="display:none" class="rightLabel">'+settings.off_label+'<\/span><\div class="clear"></div><\/div>');
			}			
			
			$(this).next().bind("click", function () { toggle($("span.switchHandle", this)); });
		});
		

	};

})(jQuery);