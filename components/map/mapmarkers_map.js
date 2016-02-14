/**
 * Initializes map
 */
var mapComponentMap;
var mapComponentInfoBox;

function mapComponentInit() {
  mapComponentMap = new google.maps.Map(document.getElementById('mapcomponent'), {
    center: {lat: 20, lng: 0},
    zoom: 2
  });

  //load markers
  $(this).request('onMarkersLoad', {
    success: mapComponentAddMarkers
  });

  //init infobox
  mapComponentInfoBox = new google.maps.InfoWindow({
    content: ''
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

  var markers = $.parseJSON(data.result);
  for (var i=0; i < markers.length; i++) {
    var marker = new google.maps.Marker({
      position: {
        lat: parseFloat(markers[i].latitude),
        lng: parseFloat(markers[i].longitude)
      },
      map: mapComponentMap,
      title: markers[i].title
    });
    marker.marker_id = markers[i].id;
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
