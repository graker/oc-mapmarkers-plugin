/**
 *  Initializes Google Map for MarkerCoords partial
 */

function markerCoordsMapInit() {
  var markerCoordsMap;
  var marker = null;

  markerCoordsMap = new google.maps.Map(document.getElementById('marker-coords-map'), {
    center: {lat: 20, lng: 0},
    zoom: 2,
    disableDoubleClickZoom: true
  });

  //check if there'are existing values, then create marker
  var latitude = $('#Form-field-Marker-latitude').val();
  var longitude = $('#Form-field-Marker-longitude').val();
  if (latitude && longitude) {
    latitude = parseFloat(latitude);
    longitude = parseFloat(longitude);
    marker = new google.maps.Marker({
      position: {
        lat: latitude,
        lng: longitude
      },
      map: markerCoordsMap
    });
    //center map to marker
    markerCoordsMap.setCenter({
      lat: latitude,
      lng: longitude
    });
  }

  /**
   * Listen double clicks on map to update latitude and longitude inputs
   */
  markerCoordsMap.addListener('dblclick', function (e) {
    var coords = e.latLng;
    if (marker) {
      marker.setPosition(coords);
    } else {
      marker = new google.maps.Marker({
        position: coords,
        map: markerCoordsMap
      });
    }

    //update coordinate inputs
    $('#Form-field-Marker-latitude').val(coords.lat);
    $('#Form-field-Marker-longitude').val(coords.lng);
  });
}
