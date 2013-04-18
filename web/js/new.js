/**
 *
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2011 Simon Lamellière

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

jQuery(document).ready(function() {

	var boxyCloseTxt = "<img onclick='$(\".boxy-remove\").remove()' src='/images/close.png'>";
	var boxyCallback = function() { if($("h2.for", ".boxy-inner").exists()) { this.setTitle( $("h2.for", ".boxy-inner").html()); $("h2.for", ".boxy-inner").remove(); } $.fn.boxyVisible(); };
		
	jQuery.fn.exists = function(){ return jQuery(this).length>0; }

	// Live events
	$(window).resize(function() {
		$.fn.boxyVisible();
	});
	
	$.fn.boxyVisible = function()
	{
		if($(".boxy-content").exists())
		{
			// Reset Height
			$(".boxy-content").css("overflow", "none").css("height", "auto");
			var WHE = parseInt($(window).height()-200);
			var BHE = $(".boxy-content").height();
			
			if(WHE > BHE)
				$(".boxy-content").css("overflow", "none").css("height", "auto");
			else
				$(".boxy-content").css("overflow", "auto").css("height", parseInt(WHE) +"px");
		}
	}
	
	$('.input :checkbox:not(.standard)').each(function(){
		
		var nname = $(this).attr("name");
		
		if(!nname.match(/photo_delete/))
			$(this).iphoneStyle({checkedLabel: "OUI", uncheckedLabel: "NON"});
	});
	
	$('body').ajaxStart(function() {
		$('.loading-overlay').show();
	});
	
	$('body').ajaxStop(function() {
		$('.loading-overlay').hide();
	});
	
	$(".sidebar ul.list.mini li").tipsy({ title: function(){ return $(".descr .title", this).text(); }, live: true, gravity: 'se' });
	$(".trigger-tipsy").tipsy({ live: true, gravity: 's' });
	
	$("#bt_cancel").live("click", function() { $(".boxy-wrapper").remove(); $(".boxy-modal-blackout").remove(); });
	$(".show-before").live("click", function() { $(this).hide().prev().show(); });
	
	/* Home live news */
	$(".close", ".hoody").live("click", function() { $("ul.switcher").hide(); $(".hoody").fadeOut(500) });
	$(".entry.new").live("click", function() { $(this).removeClass("new"); });
	
	$("li", "ul.switcher").live("click", function(){
		
		$("li", "ul.switcher").removeClass("active");
		$(this).addClass("active");
		$(".hoody").html($(".content-hoody", $(this)).html());
	});
	
	if($("li", "ul.switcher").length)
	{
		$("li", "ul.switcher").first().click();
	}
	
	$(".common-feed .entry .info .buddies img.gal").live("click", function(e){
		
		if( $(".gal-"+$(this).attr("id")).exists() )
		{
			$(".gal-"+$(this).attr("id")).click();
			e.preventDefault();
		}
	});
	
	$(".boxy-confirm").live("click", function(event){
		
		var elg = $(this);
		
		Boxy.ask("<h3>Veuillez confirmer la suppression. Cette opération est <u>irréversible</u> !</h3>", ['Oui', 'Annuler'], function(response)
		{
			if (response == 'Oui')
			{
				window.open(elg.attr("href"), "_parent");
			}
		}, {title: 'Confirmation de suppression'});
		
		event.preventDefault();
	});
	
	$(".send-test").live("click", function(event){
		var gel = $(this);
		$.ajax({
				url: gel.attr("href"),
				cache: false,
				dataType: "json",
				data: {  },
				success: function(response)
				{
					$.humanize(response.message);
				},
				error: function(){ }
			});
		event.preventDefault();
	});

	$(".boxy-send").live("click", function(event){
		
		var elg = $(this);
		
		Boxy.ask("<h3>Souhaitez-vous réellement procéder à l'envoi de ce mailing ?<br><br>Cette opération dure environ 5 à 10 secondes, elle est <u>irréversible!</u></h3>", ['Oui', 'Annuler'], function(response)
		{
			if (response == 'Oui')
			{
				$.humanize("NE CHANGEZ PAS DE PAGE... L'ENVOI EST EN COURS...");
				
				$.ajax({
					url: elg.attr("href"),
					cache: false,
					dataType: "json",
					data: {  },
					success: function(response)
					{
						$.humanize(response.message);
					},
					error: function(){ }
				});
			}
		}, {title: 'Confirmation de suppression'});
		
		event.preventDefault();
	});
	
	/* Forms extras */
	$(".content textarea").elastic();

	if( typeof $('textarea#mailing_message').tinymce === "function")
	{
		$('textarea#mailing_message').tinymce({
				// Location of TinyMCE script
				script_url : '/js/tiny_mce/tiny_mce.js',
				theme : "advanced",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "", 
				theme_advanced_buttons4 :  "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,
				force_br_newlines : true,
				force_p_newlines : false,
				forced_root_block : '' // Needed for 3.x
			});
	}
	
	$("#segment_localite" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/google/geocode/json",
					dataType: "json",
					data: {
						address: request.term,
						sensor: false
					},
					success: function( data ) {
						response( $.map( data.results, function( item )
						{
							var country = null;
							var zip = null;
							var city = "";
							var street = null;
							var number = null;
							var state = null;

							for(i in item.address_components)
							{
								if(item.address_components[i].types[0] == "administrative_area_level_1")
									state = item.address_components[i].long_name;
								if(item.address_components[i].types[0] == "country")
									country = item.address_components[i].short_name;
								if(item.address_components[i].types[0] == "locality")
									city = item.address_components[i].long_name;
								if(item.address_components[i].types[0] == "postal_code")
									zip = item.address_components[i].long_name;
								if(item.address_components[i].types[0] == "street_number")
									number = item.address_components[i].long_name;
								if(item.address_components[i].types[0] == "route")
									street = item.address_components[i].long_name;
							}

							return {
								label: city + (zip ? " (" + zip +")": "")  + (state ? ", " + state : "")  + (country ? ", " + country : ""),
								value: city,
								country: country,
								street: street,
								number: number,
								city: city,
								zip: zip,
								coordinates: item.geometry.location.lat + "," + item.geometry.location.lng
							}
						}));
					}
				});
			},
			select: function(event, ui)
			{
				$("#segment_localite").val(ui.item.label);
				event.preventDefault();
			},
			minLength: 2
		});
	
	/* Comment Module */
	$("div.voters").live("click", function() {
		
		var ctype = $(this).attr("data-ctype");
		var cid = $(this).attr("data-cid");

		new Boxy.load("/commentaire/listvote?ctype=" + ctype +"&cid="+cid, {afterShow: boxyCallback, closeText: boxyCloseTxt, title: "...", modal: true});
	});
	
	$("a", ".comment-it").live("click", function()
	{
		if( $(".comment-list form.new", $(this).parent().parent()).exists() ) 
			return false;

		// new comment on it
		if($(this).hasClass("comment-for"))
		{
			var el = $(".comment-list", $(this).parent().parent()).prepend(
				$(".new-comment-template", $(this).parent().parent()).html()
			);
			
			$("textarea", el).focus();
		}
		
		// new comment on it
		if($(this).hasClass("vote-for"))
		{
			var contexte =  $(this).parent();
			var labeled = $(this).parent().attr("data-identifier");
			var ctype = $(this).parent().attr("data-ctype");
			var cid = $(this).parent().attr("data-cid");
			
			$.ajax({
				url: "/commentaire/vote",
				cache: false,
				type: "post",
				dataType: "json",
				data: { ctype: ctype, cid: cid },
				success: function(response)
				{
					$(".voters", "#"+labeled).html(response.text);
					$(".vote-for", contexte).addClass("hide");
					$(".vote-for[data-direction="+response.show_direction+"]", contexte).removeClass("hide");
				},
				error: function(){ }
			});
		}
		
	});
	
	/* Pool selection */
	$(".pool-select .buddy :checkbox").live("click", function() {
		
		if($(this).parent().hasClass("disabled"))
			return false;
		
		if($(this).attr("checked"))
			$(this).parent().addClass("active");
		else
			$(this).parent().removeClass("active");
	});
	
	$(".pool-operate a").live("click", function() {
		
		if($(this).hasClass("all"))
		{
			$(".pool-select .buddy :checkbox").each(function(){ $(this).parent().addClass("active"); $(this).attr("checked", "checked"); });
		}
		else
		{
			$(".pool-select .buddy :checkbox").each(function(){$(this).parent().removeClass("active");  $(this).attr("checked", false); });
		}
		
	});
	
	
	/* Forms Live */
	$(":input", ".ajaxForm").live("change", function() {
		$("span.error", $(this).parent()).addClass("disabled");
		$(this).removeClass("invalid");
	});
	
	$(".ajaxForm").live("submit", function()
	{
		var contextForm = $(this);
		$(".under .confirmation").remove();
		
		$(this).ajaxSubmit(
		{
			dataType: "json",
			beforeSubmit: function()
			{
				$(":input", contextForm).prop("disabled", true);
				$("span.error", contextForm).remove();
				$(".invalid").removeClass("invalid");
			},
			error: function(s,e)
			{
				$(":input", contextForm).prop('disabled', false);
			},
			success: function(result)
			{
				$(":input", contextForm).prop('disabled', false);
				$(".big-notice", contextForm).hide();
				
				if($(contextForm, ".boxy-inner").exists())
				{
					if(result.status == 200 && result.method == "refresh")
					{
						$.humanize("OK ! Rechargement de la page...");
						window.location.reload();
					}
					else if(result.status == 200 && result.method == "goto")
					{
						window.open(result.url, "_parent");
					}
					else if(result.status == 200 && result.method == "display")
					{
						$.humanize(result.message);
						
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
					}
					else if(result.status == 200 && result.method == "space")
					{
						var elg = $(".profile .sidebar .block .slideshow[data-id="+result.id+"]");
						var templat = "<div><a class='mustang-gallery gal"+result.aid+"' title='Nouvelle photo' href='"+result.imax+"'><img src='"+result.img+"' rel='shadowbox' class='img_gal'></a></div>";
						
						elg.prepend(templat);
						
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
						
						window.setTimeout(function(){window.location.reload();}, 500);
						
						Shadowbox.setup("a.mustang-gallery", { gallery: "mustang",continuous: false, counterType: "skip" });
					}
					else if(result.status == 200 && result.method == "remove")
					{
						$.humanize(result.message);
						$("."+result.id+", #"+result.id).each(function(){
							$(this).fadeOut(300, function(){ $(this).remove(); });
						});
						
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
					}
					else if(result.status == 200 && result.method == "display-refresh")
					{
						$.humanize(result.message);
						
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
						
						window.setTimeout(function(){window.location.reload();}, 1000);
					}
					else if( result.status == 200 && result.method == "render")
					{
						if($(contextForm).hasClass("comment"))
						{
							$(contextForm).parent().prepend(result.view);
							$(contextForm).remove();
						}
					}
					else if( result.status == 200 && result.method == "prepend")
					{
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
						$.humanize(result.message);
						$(".generic-list-prepend").prepend($($.base64Decode(result.view)).fadeIn(1000));
						$(".no-results", ".generic-list-prepend").remove();
					}
					else if( result.status == 200 && result.method == "replace")
					{
						$(".boxy-wrapper").remove();
						$(".boxy-modal-blackout").remove();
						$.humanize(result.message);
						$("#"+result.id).fadeOut(300, function(){ $(this).replaceWith($.base64Decode(result.view))  });
					}
					else
					{
						$(".big-notice", contextForm).show();
						
						if(result.status == 500)
						{
							for(position in result.errors)
							{
								for(posField in result.errors[position])
								{
									$("#"+posField, contextForm).addClass("invalid").after("<div class='clear'></div> <span class='error'> ^ "+
										result.errors[position][posField] + "</span>");
									
									if(!$("#"+posField, contextForm).exists())
									{
										$(".form-"+posField, contextForm).addClass("invalid").append("<div class='clear'></div> <span class='error'> ^ "+ result.errors[position][posField] + "</span>");
									}
								}
							}
						}
						
						if($("span.error", contextForm).exists())
						{
							var ultrapos = $("span.error", contextForm).first().position();
							$('html,body').animate({scrollTop: ultrapos.top}, 600);
						}
					}
				}
			}
		});
		
		return false;
	});
	
	// Generic RR Autocompleter
	$(".ajax-f .closer").live("click", function() { $(".auto-complete", $(this).parent().parent().parent().parent() ).show(); $(this).parent().remove(); });
	
	$(".salad-ac").each(function()
	{
		if($(".counter", $(this)).exists())
		{
			var rs = new Array();
			var ctx=$(this);
			
			$(".salad input[type='hidden']", ctx).each(function(){ rs.push($(this).val()); })
			
			$.ajax({ data: { filter: rs }, url: $(".counter", $(this)).attr("data-url"), type: 'get', cache: false, dataType: 'json', success: function(rs)
				{	
					$(".counter", ctx).html(rs.label);
				}
			});
		}
	});
	
	$(".auto-complete").live("focus", function()
	{
		if($(this).hasClass("managed"))
			return false;

		$.fn.addResult = function(val)
		{
			if( !$("input[value="+val.id+"]", $(".salad-ac .salad", $(this).parent()) ).exists() )
			{
				$(".salad-ac .salad", $(this).parent()).prepend(
					$.sprintf($(".salad-ac .source", $(this).parent()).html(), val.label, $(this).attr("data-field-name"), val.id)
				);
				
				if( parseInt( $(this).attr("data-max-choices") ) <= $(".salad-ac .salad input", $(this).parent()).length )
				{
					$(this).hide();
				}
				
				// Refresh counter ?
				if( $(".salad-ac .counter", $(this).parent()).exists() )
				{
					var rs = new Array();
					var ctx = $(this).parent();
					
					$(".salad input[type='hidden']", ctx).each(function(){ rs.push($(this).val()); })
					
					$.ajax({ data: { filter: rs }, url: $(".counter", ctx).attr("data-url"), type: 'get', cache: false, dataType: 'json', success: function(rs)
						{	
							$(".counter", ctx).html(rs.label);
						}
					});
				}
			}
			
			$(this)
				.val("")
				.focus();
		};
		
		$(this).autocomplete({
			minLength: 1,
			selectFirst: true,
			source: "/json/" + $(this).attr("data-class") + "?eid=" + $(this).attr("data-eid"),
			focus: function( event, ui ) {
				return false;
			},
			select: function( event, ui ) 
			{
				if(ui.item.id == "create-it")
				{
					$(this).prop("disabled", true);
					var contextedField = $(this);

					$.ajax({
						url: "/json/" + $(this).attr("data-class"),
						cache: false,
						type: "post",
						dataType: "json",
						data: { term: $(this).val() },
						success: function(response)
						{
							contextedField.prop("disabled", false);
							contextedField.addResult(response);
						},
						error: function(){ contextedField.prop("disabled", false); }
					});
				}
				else
				{
					$(this).addResult(ui.item);
				}

				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
		};
		
		// Select First Item
		$(this).keypress( function (e) 
		{
			if(e.which == 13)
			{
				$(this).focus();
				e.preventDefault();
			}
		});
		
		$(this).addClass("managed");
	});
	
	// Ajax actions
	$(".ajax-action").live("click", function(event){
		
		var dest = $(this).attr("data-destination");
		
		$.ajax({
					url: $(this).attr("href"),
					type: "GET",
					data: {  },
					success: function(data)
					{
						$("#"+dest).html(data);
					},
					error: function()
					{
					}
				});
		
		event.preventDefault();
	});
	
	// Live actions
	$(".live-action").live("click", function(){
		
		var closeTxt = "<img onclick='$(\".boxy-remove\").remove()' src='/images/close.png'>";
		var uid = $(this).attr("data-to");
		var dty = $(this).attr("data-type");
		var more = ($(this).attr("data-more") ? "&" + $(this).attr("data-more") : "");

		if($(this).hasClass("disabled"))
			return false;
		
		switch($(this).attr("data-action"))
		{
			case "wishco":
				new Boxy.load("/invite/wish_confirm?wid=" + uid, {closeText: boxyCloseTxt, afterShow: boxyCallback, modal: true});
			break;
			
			case "wish":
				$.ajax({
					url: "/invite/wish",
					dataType: "json",
					type: "GET",
					data: { pid: uid },
					success: function(data)
					{
						$.humanize(data.message);
					},
					error: function()
					{
					}
				});
			break;
			case "youtube":
				new Boxy.load("/actions/video?id=" + uid, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "add-photo":
				new Boxy.load("/galerie/add?id=0&"+dty+"=" + uid, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "joinp":
				new Boxy.load("/actions/join_projet?type="+dty+"&pid=" + uid +"&role=" + $(this).attr("data-role"), {closeText: boxyCloseTxt, modal: true});
			break;
			case "attending":
				new Boxy.load("/actions/join_event?eid=" + uid +"&direction=" + $(this).attr("data-more"), {closeText: boxyCloseTxt,  modal: true});
			break;
			case "inbox":
				new Boxy.load("/inbox/send?did=" + uid + more, {closeText: boxyCloseTxt, title: "Envoyer un message", afterShow: boxyCallback, modal: true});
			break;
			case "inbox-remove":
				new Boxy.load("/inbox/remove?mid=" + uid + more, {closeText: boxyCloseTxt, modal: true});
			break;
			case "friend":
				new Boxy.load("/actions/add_contact?uid=" + uid + more, {closeText: boxyCloseTxt, afterShow: boxyCallback, modal: true});
			break;
			case "project_admin":
				new Boxy.load("/actions/admin_project?uid=" + uid + more, {closeText: boxyCloseTxt, afterShow: boxyCallback, modal: true});
			break;
			case "structure_admin":
				new Boxy.load("/actions/admin_structure?uid=" + uid + more, {closeText: boxyCloseTxt, afterShow: boxyCallback, modal: true});
			break;
			case "invite":
				new Boxy.load("/invite/index?go=1&" + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "mailing":
				new Boxy.load("/invite/mailing?go=1&" + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "comment-remove":
				new Boxy.load("/commentaire/remove?cid=" + uid, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "ressource-remove":
				new Boxy.load("/ressource/remove?pid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "ressource":
				if(dty == "project")
					new Boxy.load("/ressource/add?pid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
				else if(dty == "event")
					new Boxy.load("/ressource/add?eid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
				else if(dty == "edit-pass")
					new Boxy.load("/ressource/add?continue=true" + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "idea-remove":
				new Boxy.load("/ideas/remove?iid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "idea":
				if(dty == "project")
					new Boxy.load("/ideas/add?pid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
				else if(dty == "event")
					new Boxy.load("/ideas/add?eid=" + uid + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
				else if(dty == "edit-pass")
					new Boxy.load("/ideas/add?continue=true" + more, {closeText: boxyCloseTxt, title: "...", afterShow: boxyCallback, modal: true});
			break;
			case "invitation":
				$.ajax({
					url: "/invite/hide",
					dataType: "json",
					type: "GET",
					data: { iid: uid },
					success: function(data)
					{
						if(data.status == 200)
							$("#invitation_"+uid).fadeOut(400);
						else
							$.humanize(data.message);
					},
					error: function()
					{
					}
				});
			break;
			default:
				return false;
			break;
		}
		
	});

	// Scrolls
	$('ul.list.big').jScrollPane();
	$('ul.list.mini').jScrollPane();
	$(".slideshow").jScrollPane();
	$('.sub.big .container').jScrollPane();
	$(".inner .menu li.left .sub").hide();
}); 

/**
 * sprintf and vsprintf for jQuery
 * somewhat based on http://jan.moesen.nu/code/javascript/sprintf-and-printf-in-javascript/
 * 
 * Copyright (c) 2008 Sabin Iacob (m0n5t3r) <iacobs@m0n5t3r.info>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details. 
 *
 * @license http://www.gnu.org/licenses/gpl.html 
 * @project jquery.sprintf
 */
(function($){
	var formats = {
		'b': function(val) {return parseInt(val, 10).toString(2);},
		'c': function(val) {return String.fromCharCode(parseInt(val, 10));},
		'd': function(val) {return parseInt(val, 10);},
		'u': function(val) {return Math.abs(val);},
		'f': function(val, p) {
			p = parseInt(p, 10); 
			val = parseFloat(val);
			if(isNaN(p && val)) {
				return NaN;
			}
			return p && val.toFixed(p) || val;
		},
		'o': function(val) {return parseInt(val, 10).toString(8);},
		's': function(val) {return val;},
		'x': function(val) {return ('' + parseInt(val, 10).toString(16)).toLowerCase();},
		'X': function(val) {return ('' + parseInt(val, 10).toString(16)).toUpperCase();}
	};

	var re = /%(?:(\d+)?(?:\.(\d+))?|\(([^)]+)\))([%bcdufosxX])/g;

	var dispatch = function(data){
		if(data.length == 1 && typeof data[0] == 'object') { //python-style printf
			data = data[0];
			return function(match, w, p, lbl, fmt, off, str) {
				return formats[fmt](data[lbl]);
			};
		} else { // regular, somewhat incomplete, printf
			var idx = 0; 
			return function(match, w, p, lbl, fmt, off, str) {
				if(fmt == '%') {
					return '%';
				}
				return formats[fmt](data[idx++], p);
			};
		}
	};

	$.extend({
		sprintf: function(format) {
			var argv = Array.apply(null, arguments).slice(1);
			return format.replace(re, dispatch(argv));
		},
		vsprintf: function(format, data) {
			return format.replace(re, dispatch(data));
		}
	});
})(jQuery);

/*
* jQuery UI Autocomplete Select First Extension
*
* Copyright 2010, Scott González (http://scottgonzalez.com)
* Dual licensed under the MIT or GPL Version 2 licenses.
*
* http://github.com/scottgonzalez/jquery-ui-extensions
*
* patch by Simon Lamelliere
*/
(function( $ ) {

	$(".ui-autocomplete-input").live( "autocompleteopen", function()
	{
		var autocomplete = $( this ).data( "autocomplete" ),
		menu = autocomplete.menu;

		if ( !autocomplete.options.selectFirst ) {
			return;
		}

		$(".ui-autocomplete-input").bind('keyup', function(e)
		{
			$(".ui-autocomplete-input").unbind('keyup');

			if(e.which == 13 && $('.ui-state-hover').height() == null)
			{
				menu.activate( $.Event({ type: "mouseenter" }), menu.element.children().first() );
				menu.select( $.Event({ type: "mouseenter" }), menu.element.children().first() );
			}
		});

	});

}( jQuery ));

	
	/**
	 * jQuery BASE64 functions
	 * 
	 * 	<code>
	 * 		Encodes the given data with base64. 
	 * 		String $.base64Encode ( String str )
	 *		<br />
	 * 		Decodes a base64 encoded data.
	 * 		String $.base64Decode ( String str )
	 * 	</code>
	 * 
	 * Encodes and Decodes the given data in base64.
	 * This encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean, such as mail bodies.
	 * Base64-encoded data takes about 33% more space than the original data. 
	 * This javascript code is used to encode / decode data using base64 (this encoding is designed to make binary data survive transport through transport layers that are not 8-bit clean). Script is fully compatible with UTF-8 encoding. You can use base64 encoded data as simple encryption mechanism.
	 * If you plan using UTF-8 encoding in your project don't forget to set the page encoding to UTF-8 (Content-Type meta tag). 
	 * This function orginally get from the WebToolkit and rewrite for using as the jQuery plugin.
	 * 
	 * Example
	 * 	Code
	 * 		<code>
	 * 			$.base64Encode("I'm Persian."); 
	 * 		</code>
	 * 	Result
	 * 		<code>
	 * 			"SSdtIFBlcnNpYW4u"
	 * 		</code>
	 * 	Code
	 * 		<code>
	 * 			$.base64Decode("SSdtIFBlcnNpYW4u");
	 * 		</code>
	 * 	Result
	 * 		<code>
	 * 			"I'm Persian."
	 * 		</code>
	 * 
	 * @alias Muhammad Hussein Fattahizadeh < muhammad [AT] semnanweb [DOT] com >
	 * @link http://www.semnanweb.com/jquery-plugin/base64.html
	 * @see http://www.webtoolkit.info/
	 * @license http://www.gnu.org/licenses/gpl.html [GNU General Public License]
	 * @param {jQuery} {base64Encode:function(input))
	 * @param {jQuery} {base64Decode:function(input))
	 * @return string
	 */
	
	(function($){
		
		var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
		
		var uTF8Encode = function(string) {
			string = string.replace(/\x0d\x0a/g, "\x0a");
			var output = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if (c < 128) {
					output += String.fromCharCode(c);
				} else if ((c > 127) && (c < 2048)) {
					output += String.fromCharCode((c >> 6) | 192);
					output += String.fromCharCode((c & 63) | 128);
				} else {
					output += String.fromCharCode((c >> 12) | 224);
					output += String.fromCharCode(((c >> 6) & 63) | 128);
					output += String.fromCharCode((c & 63) | 128);
				}
			}
			return output;
		};
		
		var uTF8Decode = function(input) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
			while ( i < input.length ) {
				c = input.charCodeAt(i);
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				} else if ((c > 191) && (c < 224)) {
					c2 = input.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				} else {
					c2 = input.charCodeAt(i+1);
					c3 = input.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
			}
			return string;
		}
		
		$.extend({
			base64Encode: function(input) {
				var output = "";
				var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
				var i = 0;
				input = uTF8Encode(input);
				while (i < input.length) {
					chr1 = input.charCodeAt(i++);
					chr2 = input.charCodeAt(i++);
					chr3 = input.charCodeAt(i++);
					enc1 = chr1 >> 2;
					enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
					enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
					enc4 = chr3 & 63;
					if (isNaN(chr2)) {
						enc3 = enc4 = 64;
					} else if (isNaN(chr3)) {
						enc4 = 64;
					}
					output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
				}
				return output;
			},
			base64Decode: function(input) {
				var output = "";
				var chr1, chr2, chr3;
				var enc1, enc2, enc3, enc4;
				var i = 0;
				input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
				while (i < input.length) {
					enc1 = keyString.indexOf(input.charAt(i++));
					enc2 = keyString.indexOf(input.charAt(i++));
					enc3 = keyString.indexOf(input.charAt(i++));
					enc4 = keyString.indexOf(input.charAt(i++));
					chr1 = (enc1 << 2) | (enc2 >> 4);
					chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
					chr3 = ((enc3 & 3) << 6) | enc4;
					output = output + String.fromCharCode(chr1);
					if (enc3 != 64) {
						output = output + String.fromCharCode(chr2);
					}
					if (enc4 != 64) {
						output = output + String.fromCharCode(chr3);
					}
				}
				output = uTF8Decode(output);
				return output;
			}
		});
	})(jQuery);

/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function raw(s) {
		return s;
	}

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	function converted(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}
		try {
			return config.json ? JSON.parse(s) : s;
		} catch(er) {}
	}

	var config = $.cookie = function (key, value, options) {

		// write
		if (value !== undefined) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				config.raw ? key : encodeURIComponent(key),
				'=',
				config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// read
		var decode = config.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {};
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = decode(parts.join('='));

			if (key && key === name) {
				result = converted(cookie);
				break;
			}

			if (!key) {
				result[name] = converted(cookie);
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			$.cookie(key, '', $.extend(options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));