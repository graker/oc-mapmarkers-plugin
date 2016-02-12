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
