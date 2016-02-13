<?php

namespace Graker\MapMarkers\Widgets;

use Backend\Classes\WidgetBase;


class MarkersMap extends WidgetBase {

  /**
   * @var string widget alias
   */
  protected $defaultAlias = 'markersmap';


  /**
   * @return array of widget info
   */
  public function widgetDetails() {
    return [
      'name' => 'Markers Map',
      'description' => 'Widget to display map with all markers on it in the Backend',
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
    return $this->makePartial('markersmap');
  }


  /**
   * Adds Google Map script and local asset script to page
   */
  protected function addGmapJs() {
    //local asset
    $this->addJs('/plugins/graker/mapmarkers/widgets/markersmap/assets/js/markersmap.js');

    //Google Map
    $this->addJs(
      'https://maps.googleapis.com/maps/api/js?callback=markersMapInit',
      [
        'async',
        'defer',
      ]
    );
  }

}
