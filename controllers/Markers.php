<?php namespace Graker\MapMarkers\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Graker\MapMarkers\Widgets\MarkersMap;
use Graker\MapMarkers\Models\Marker;

/**
 * Markers Back-end Controller
 */
class Markers extends Controller
{
  public $implement = [
    'Backend.Behaviors.FormController',
    'Backend.Behaviors.ListController'
  ];

  public $formConfig = 'config_form.yaml';
  public $listConfig = 'config_list.yaml';

  /**
   * Constructor
   * Binds MarkersMap widget
   */
  public function __construct()
  {
    parent::__construct();

    //bind MarkersMap widget
    $map = new MarkersMap($this);
    $map->alias = 'MarkersMap';
    $map->bindToController();

    BackendMenu::setContext('Graker.MapMarkers', 'mapmarkers', 'markers');
  }


  /**
   *
   * Overriding create() method to add javascript for coordinates
   *
   * @param string $context
   */
  public function create($context = '') {
    $this->addMapJS();
    return $this->asExtension('FormController')->create($context);
  }


  /**
   *
   * Overriding update() method to add javascript for coordinates
   *
   * @param $recordId
   * @param string $context
   * @return mixed
   */
  public function update($recordId, $context = '') {
    $this->addMapJS();
    return $this->asExtension('FormController')->update($recordId, $context);
  }


  /**
   * Adds scripts needed for map coords functionality
   */
  protected function addMapJS() {
    //add local map init script and google map script
    $this->addJs('/plugins/graker/mapmarkers/controllers/markers/markercoords.js');
    $this->addJs(
      'https://maps.googleapis.com/maps/api/js?callback=markerCoordsMapInit',
      [
        'async',
        'defer',
      ]
    );
  }


  /**
   *
   * AJAX callback
   * Returns array of all markers in the system
   *
   * @return Marker[]
   */
  public function onMarkersLoad() {
    $markers = Marker::all();
    return $markers->toJson();
  }

}
