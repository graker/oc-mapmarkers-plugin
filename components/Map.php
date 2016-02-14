<?php namespace Graker\MapMarkers\Components;

use Cms\Classes\ComponentBase;
use Graker\MapMarkers\Models\Marker;
use Request;

class Map extends ComponentBase
{

  public function componentDetails() {
    return [
      'name'        => 'Map',
      'description' => 'Google map with markers'
    ];
  }


  /**
   *
   * Define component properties
   *
   * @return array
   */
  public function defineProperties() {
    return [];
  }


  /**
   * Adds scripts needed for map functionality
   */
  protected function addMapJS() {
    //add local map init script and google map script
    $this->addJs('/plugins/graker/mapmarkers/components/map/mapmarkers_map.js');
    $this->addJs(
      'https://maps.googleapis.com/maps/api/js?callback=mapComponentInit',
      [
        'async',
        'defer',
      ]
    );
  }


  /**
   * onRun event
   */
  public function onRun() {
    $this->addMapJS();
  }


  /**
   *
   * Returns JSON with all site markers (including attached image, referenced albums and posts)
   *
   * @return string json
   */
  public function onMarkersLoad() {
    $markers = Marker::all();
    return $markers->toJson();
  }


  /**
   *
   * Renders info box in response to marker's click
   *
   * @return string
   */
  public function onMarkerClicked() {
    $id = Request::input('marker_id');
    $model = Marker::where('id', $id)->with('posts')->with('albums')->with('image')->first();

    if ($model->image) {
      $model->image->thumb = $model->image->getThumb(120, 120, ['mode' => 'auto']);
    }

    return $this->renderPartial('::popup', ['marker' => $model]);
  }

}
