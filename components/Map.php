<?php namespace Graker\MapMarkers\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Graker\MapMarkers\Models\Marker;
use Illuminate\Database\Eloquent\Collection;
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
    return [
      'centerLat' => [
        'title'       => 'Center latitude',
        'description' => 'Latitude of map center (float)',
        'type'        => 'string',
        'default'     => 0.0,
      ],
      'centerLng' => [
        'title'       => 'Center longitude',
        'description' => 'Longitude of map center (float)',
        'type'        => 'string',
        'default'     => 0.0,
      ],
      'zoom' => [
        'title'       => 'Default zoom',
        'description' => 'Map zoom by default',
        'type'        => 'string',
        'default'     => 2,
      ],
      'mapMarker' => [
        'title'       => 'Map Marker',
        'description' => 'Path to map marker image',
        'default'     => '',
        'type'        => 'string'
      ],
      'postPage' => [
        'title'       => 'Blog post page',
        'description' => 'Page used to display blog posts',
        'type'        => 'dropdown',
        'default'     => 'blog/post',
      ],
      'albumPage' => [
        'title'       => 'Album page',
        'description' => 'Page used to display photo albums',
        'type'        => 'dropdown',
        'default'     => 'photoalbums/album',
      ],
    ];
  }


  /**
   *
   * Returns pages list for album page select box setting
   *
   * @return mixed
   */
  public function getAlbumPageOptions() {
    return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
  }


  /**
   *
   * Returns pages list for album page select box setting
   *
   * @return mixed
   */
  public function getPostPageOptions() {
    return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
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
   * Returns JSON with all data needed:
   *  - .settings - global map settings (marker icon)
   *  - .markers - markers data: title and coordinates
   *
   * @return string json
   */
  public function onDataLoad() {
    $data = array();
    $data['settings'] = $this->createSettingsArray();
    $markers = $this->loadMarkers();
    $data['markers'] = $markers->toArray();
    return json_encode($data);
  }


  /**
   * @return Collection of all markers
   */
  protected function loadMarkers() {
    $markers = Marker::all();
    return $markers;
  }


  /**
   *
   * Creates array of settings to pass to JS as JSON
   *
   * @return array
   */
  protected function createSettingsArray() {
    $settings = array();
    $settings['image'] = $this->property('mapMarker');
    $settings['zoom'] = $this->property('zoom');
    $settings['center'] = [
      'lat' => $this->property('centerLat'),
      'lng' => $this->property('centerLng'),
    ];
    return $settings;
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

    //setup urls for posts and albums
    if ($model->posts) {
      foreach ($model->posts as $post) {
        $post->setUrl($this->property('postPage'), $this->controller);
      }
    }
    if ($model->albums) {
      foreach ($model->albums as $album) {
        $album->setUrl($this->property('albumPage'), $this->controller);
      }
    }

    return $this->renderPartial('::popup', ['marker' => $model]);
  }

}
