/**
 * Initializes map
 */
var mapComponentMap;
var mapComponentInfoBox;

function mapComponentInit() {
  //load settings and markers
  $(this).request('onDataLoad', {
    success: mapComponentAddMarkers
  });
}


/**
 * Adds markers to map
 * Markers are expected to be a JSON in data.result
 */
function mapComponentAddMarkers(data) {
  if (data.result == undefined) {
    return ;
  }
  var loadedData = $.parseJSON(data.result);

  // init map with settings
  mapComponentMap = new google.maps.Map(document.getElementById('mapcomponent'), {
    center: {
      lat: parseFloat(loadedData.settings.center.lat),
      lng: parseFloat(loadedData.settings.center.lng)
    },
    zoom: parseInt(loadedData.settings.zoom)
  });

  // init infobox
  mapComponentInfoBox = new google.maps.InfoWindow({
    content: ''
  });

  // create marker icon
  var iconUrl = loadedData.settings.image;
  var Icon = null;
  if (iconUrl) {
    Icon = {
      url: iconUrl,
      anchor: new google.maps.Point(parseInt(loadedData.settings.x_offset), parseInt(loadedData.settings.y_offset))
    };
  }

  for (var i=0; i < loadedData.markers.length; i++) {
    var marker = new google.maps.Marker({
      position: {
        lat: parseFloat(loadedData.markers[i].latitude),
        lng: parseFloat(loadedData.markers[i].longitude)
      },
      map: mapComponentMap,
      title: loadedData.markers[i].title,
      icon: Icon
    });
    marker.marker_id = loadedData.markers[i].id;
    //bind marker click to show info box
    marker.addListener('click', function () {
      var clickedMarker = this;
      $(this).request('onMarkerClicked', {
        data: {marker_id: clickedMarker.marker_id},
        success: function (data) {
          mapComponentInfoBox.setContent(data.result);
          mapComponentInfoBox.open(mapComponentMap, clickedMarker);
        }
      });
    });
  }
}
