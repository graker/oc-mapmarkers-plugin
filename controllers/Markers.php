<?php namespace Graker\MapMarkers\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

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

  public function __construct()
  {
    parent::__construct();

    BackendMenu::setContext('Graker.MapMarkers', 'mapmarkers', 'markers');
  }
}
