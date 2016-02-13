/**
 * Initializes map
 */
var mapComponentMap;
function mapComponentInit() {
  mapComponentMap = new google.maps.Map(document.getElementById('mapcomponent'), {
    //TODO setup center from settings
    center: {lat: 20, lng: 0},
    zoom: 2
  });

  //load markers
  $(this).request('onMarkersLoad', {
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
  }
}
