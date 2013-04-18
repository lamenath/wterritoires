<script type="text/javascript">

	var map, curCent, default_pos, infoWindow, BuddyImage, ProjectImage;
	var markersArray = [];

	// Deletes all markers in the array by removing references to them
	function deleteOverlays() {
		if (markersArray) {
			for (i in markersArray) {
				markersArray[i].setMap(null);
			}
			markersArray.length = 0;
		}
	}

	function addMarkers()
	{
		deleteOverlays();

		function createMarker(typ, id, title, url, bio, city, pic, lat, lon)
		{
			var marker = new google.maps.Marker({
				map: map,
				icon: (typ == "user" ? BuddyImage : (typ == "project" ? ProjectImage : StructureImage)),
				draggable: false,
				title: title,
				position: new google.maps.LatLng(lat, lon)
			});

			markersArray.push(marker);

			google.maps.event.addListener(marker, 'click', function() {
				var myHtml = '<div id="'+id+'" class="map-rr"><a href='+url+' target="_blank"><img src="'+pic+'"><div class="contents"><h3>' + title + '</h3><h4>'+city+'</h4><p>' + bio +"</p></a></div></div>";
				infoWindow.setContent(myHtml);
				infoWindow.open(map, marker);
			});
		}

		$.ajax({
			url: "<?php echo url_for("json/feed?keyword=".$object->getNom()); ?>",
			dataType: "json",
			type: "GET",
			data: { lat: map.getCenter().lat(), lng: map.getCenter().lng() },
			success: function(data)
			{
				for(lin in data)
				{
					createMarker(data[lin].type, data[lin].id, data[lin].title, data[lin].url, data[lin].bio, data[lin].city, data[lin].picture, data[lin].lat, data[lin].lon);
				}
			},
			error: function()
			{
			}
		});
	}

	function initialize()
	{
		var myOptions = {
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		infoWindow = new google.maps.InfoWindow();
		map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
		default_pos = new google.maps.LatLng(<?php echo sfConfig::get("app_gps_center_default"); ?>);

		BuddyImage = new google.maps.MarkerImage(
						"/images/icon_person.png",
						new google.maps.Size(50,50),
						new google.maps.Point(0,0),
						new google.maps.Point(0,35)
					);

		ProjectImage = new google.maps.MarkerImage(
						"/images/icon_project.png",
						new google.maps.Size(19,19),
						new google.maps.Point(0,0),
						new google.maps.Point(0,35)
					);

		StructureImage = new google.maps.MarkerImage(
						"/images/icon_business.png",
						new google.maps.Size(19,19),
						new google.maps.Point(0,0),
						new google.maps.Point(0,35)
					);

		// Try HTML5 geolocation
		if(navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(function(position)
			{
				var pos = new google.maps.LatLng(position.coords.latitude,
								 position.coords.longitude);
				map.setCenter(pos);
			},
			function() {
				map.setCenter(default_pos);
			});
		}
		else
		{
			map.setCenter(default_pos);
		}

		google.maps.Map.prototype.clearMarkers = function() {
			if(this.markers != undefined)
			{
				for(var i=0; i < this.markers.length; i++){
					this.markers[i].setMap(null);
				}
				this.markers = new Array();
			}
		};

		google.maps.event.addListenerOnce(map, 'tilesloaded', addMarkers);
		google.maps.event.addListener(map, 'dragend', addMarkers);
	}

	function handleNoGeolocation(errorFlag)
	{
		if (errorFlag) {
			var content = 'Error: The Geolocation service failed.';
		} else {
			var content = 'Error: Your browser doesn\'t support geolocation.';
		}

		var options = {
			map: map,
			position: new google.maps.LatLng(60, 105),
			content: content
		};

		var infowindow = new google.maps.InfoWindow(options);
		map.setCenter(options.position);
	}

	google.maps.event.addDomListener(window, 'load', initialize);

</script>
<div class="container-map">
	<div id="map_canvas"></div>
</div>
