

/**
 *  Initializes Google Map for Markers Map widget
 */
var markersMap;
function markersMapInit() {
  markersMap = new google.maps.Map(document.getElementById('markersmap'), {
    center: {lat: 20, lng: 0},
    zoom: 2
  });

  $(this).request('onMarkersLoad', {
    success: markersMapAddMarkers
  });
}


/**
 * Adds markers to map
 */
function markersMapAddMarkers(markers) {
  //cycle through markers
  for (var i=0; i < (markers.length - 1); i++) {
    var marker = new google.maps.Marker({
      position: {lat: markers[i].latitude, lng: markers[i].longitude},
      map: markersMap,
      title: markers[i].title
    });
  }
}
