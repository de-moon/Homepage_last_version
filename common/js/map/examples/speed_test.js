/**
 * @fileoverview This demo is used for MarkerClusterer. It will show 100 markers
 * using MarkerClusterer and count the time to show the difference between using
 * MarkerClusterer and without MarkerClusterer.
 * @author Luke Mahe (v2 author: Xiaoxi Wu)
 */

function $_(element) {
  return document.getElementById(element);
}

var speedTest = {};

speedTest.count = 0;
speedTest.pics = null;
speedTest.map = null;
speedTest.markerClusterer = null;
speedTest.markers = [];
speedTest.infoWindow = null;

  var customMapType = new google.maps.StyledMapType([
      {
        stylers: [
          {hue: '#ccffff'},
          {visibility: 'simplified'},
          {gamma: 0.5},
          {weight: 0.5}
        ]
      },
      {
        elementType: 'labels',
        stylers: [{visibility: 'off'}]
      },
      {
        featureType: 'water',
        stylers: [{color: '#ccffcc'}]
      }
    ], {
      name: 'Custom Style'
  });
  var customMapTypeId = 'custom_style';

speedTest.init = function() {
	var latlng
	var options

	var useDivision = document.getElementById('use_division');
	if ( String(useDivision) != "undefined" && useDivision != null) {
		if (useDivision.value == "DOMESTIC") {
			latlng = new google.maps.LatLng(36.42, 128.11);
			options = {
				'zoom': 7,
				'center': latlng,
				'mapTypeId': google.maps.MapTypeId.ROADMAP
			};
		} else {
			latlng = new google.maps.LatLng(39.91, 78.38);
			options = {
				'zoom': 2,
				'center': latlng,
				'mapTypeId': google.maps.MapTypeId.ROADMAP
			};
		}
	} else {
			var latlng = new google.maps.LatLng(39.91, 116.38);
			var options = {
			'zoom': 2,
			'center': latlng,
			'mapTypeId': google.maps.MapTypeId.ROADMAP
			};
	}

  speedTest.map = new google.maps.Map($_('map'), options);
  speedTest.pics = data.photos;
  speedTest.count = data.count;
  
  var useGmm = document.getElementById('usegmm');
  google.maps.event.addDomListener(useGmm, 'click', speedTest.change);
  
//  var numMarkers = document.getElementById('nummarkers');
//  google.maps.event.addDomListener(numMarkers, 'change', speedTest.change);

//  speedTest.map.mapTypes.set(customMapTypeId, customMapType);
//  speedTest.map.setMapTypeId(customMapTypeId);

  speedTest.infoWindow = new google.maps.InfoWindow();

  speedTest.showMarkers();
};

speedTest.showMarkers = function() {
  speedTest.markers = [];

//  var type = 1;
//  if ($_('usegmm').checked) {
//    type = 0;
//  }

  if (speedTest.markerClusterer) {
    speedTest.markerClusterer.clearMarkers();
  }

  var panel = $_('markerlist');
  panel.innerHTML = '';
//  var numMarkers = $_('nummarkers').value;
  var numMarkers = speedTest.count;

  for (var i = 0; i < numMarkers; i++) {
    var titleText = speedTest.pics[i].subject;
    if (titleText === '') {
      titleText = 'No title';
    }

    var item = document.createElement('DIV');
    var title = document.createElement('A');
    title.href = '#';
    title.className = 'title';
    title.innerHTML = titleText;

    item.appendChild(title);
    panel.appendChild(item);


    var latLng = new google.maps.LatLng(speedTest.pics[i].latitude,
        speedTest.pics[i].longitude);

    var imageUrl = '/images/common/map_icon.png';
    var markerImage = new google.maps.MarkerImage(imageUrl,
        new google.maps.Size(34, 52));

    var marker = new google.maps.Marker({
      'position': latLng,
      'icon': markerImage
    });

    var latLng2 = new google.maps.LatLng(speedTest.pics[i].latitude+0.0009,
        speedTest.pics[i].longitude);

    var fn = speedTest.markerClickFunction(speedTest.pics[i], latLng2);
//    var fn = speedTest.markerClickFunction(speedTest.pics[i], latLng);
    google.maps.event.addListener(marker, 'click', fn);
    google.maps.event.addDomListener(title, 'click', fn);
    speedTest.markers.push(marker);
  }

  window.setTimeout(speedTest.time, 0);
};

speedTest.markerClickFunction = function(pic, latlng) {
  return function(e) {
    e.cancelBubble = true;
    e.returnValue = false;
    if (e.stopPropagation) {
      e.stopPropagation();
      e.preventDefault();
    }
    var num = pic.num;
    var division = pic.division;
    var subject = pic.subject;
    var delegate_img = pic.delegate_img;
    var address = pic.address;

	var infoHtml = '';
	infoHtml = infoHtml + '<div class="map_cont">';
	infoHtml = infoHtml + '	<ul>';
	infoHtml = infoHtml + '		<strong>' + subject + '</strong>';
	infoHtml = infoHtml + '		<li>' + address + '</li>';
	infoHtml = infoHtml + '		<p><a href="board_view.asp?num=' + num + '">자세히보기</a></p>';
	infoHtml = infoHtml + '		<img class="map_img" src="' + delegate_img + '" width="220" height="80" alt="">';
	infoHtml = infoHtml + '	</ul>';
	infoHtml = infoHtml + '</div>';

	speedTest.map.setZoom(16);
	speedTest.map.setCenter(latlng);
    speedTest.infoWindow.setContent(infoHtml);
    speedTest.infoWindow.setPosition(latlng);
    speedTest.infoWindow.open(speedTest.map);
  };
};

speedTest.clear = function() {
//  $_('timetaken').innerHTML = 'cleaning...';
  for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
    marker.setMap(null);
  }
};

speedTest.change = function() {
  speedTest.clear();
  speedTest.showMarkers();
};

speedTest.time = function() {
//  $_('timetaken').innerHTML = 'timing...';
  var start = new Date();
  if ($_('usegmm').checked) {
    speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers, {imagePath: '/common/js/map/images/m'});
  } else {
    for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
      marker.setMap(speedTest.map);
    }
  }

  var end = new Date();
//  $_('timetaken').innerHTML = end - start;
};
