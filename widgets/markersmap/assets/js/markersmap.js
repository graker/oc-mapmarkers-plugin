

/**
 *  Initializes Google Map for Markers Map widget
 */
var markersMap;
function markersMapInit() {
  markersMap = new google.maps.Map(document.getElementById('markersmap'), {
    center: {lat: 20, lng: 0},
    zoom: 2
  });

  //load markers
  $(this).request('onMarkersLoad', {
    success: markersMapAddMarkers
  });
}


/**
 * Adds markers to map
 * Markers are expected to be a JSON in data.result
 */
function markersMapAddMarkers(data) {
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
      map: markersMap,
      title: markers[i].title
    });
  }
}
