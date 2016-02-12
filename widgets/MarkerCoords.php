<?php

namespace Graker\MapMarkers\Widgets;

use Backend\Classes\WidgetBase;


class MarkerCoords extends WidgetBase {

  /**
   * @var string widget alias
   */
  protected $defaultAlias = 'markercoords';


  /**
   * @return array of widget info
   */
  public function widgetDetails() {
    return [
      'name' => 'Marker Coordinates',
      'description' => 'Widget to select marker\'s latitude and longitude by clicking on Google Map',
    ];
  }


  /**
   *
   * Renders widget HTML
   *
   * @return mixed
   */
  public function render() {
    $this->addGmapJs();
    return $this->makePartial('markercoords');
  }


  /**
   * Adds Google Map script and local asset script to page
   */
  protected function addGmapJs() {
    //local asset
    $this->addJs('/plugins/graker/mapmarkers/widgets/markercoords/assets/js/markercoords.js');

    //Google Map
    $this->addJs(
      'https://maps.googleapis.com/maps/api/js?callback=markersMapInit',
      [
        'async',
        'defer',
      ]);
  }

}
