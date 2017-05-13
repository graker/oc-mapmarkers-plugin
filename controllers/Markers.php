<?php namespace Graker\MapMarkers\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Graker\MapMarkers\Models\Settings;
use Graker\MapMarkers\Widgets\MarkersMap;
use Graker\MapMarkers\Models\Marker;

/**
 * Markers Back-end Controller
 */
class Markers extends Controller
{
    public $implement = [
      'Backend.Behaviors.FormController',
      'Backend.Behaviors.ListController',
      'Backend.Behaviors.ReorderController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';

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
     * and javascript for checkbox searches
     *
     * @param string $context
     */
    public function create($context = '') {
        $this->addMapAssets();
        $this->addJs('/plugins/graker/mapmarkers/assets/js/checkboxlist-searchable.js');
        return $this->asExtension('FormController')->create($context);
    }


    /**
     *
     * Overriding update() method to add javascript for coordinates
     * and javascript for checkbox searches
     *
     * @param $recordId
     * @param string $context
     * @return mixed
     */
    public function update($recordId, $context = '') {
        $this->addMapAssets();
        return $this->asExtension('FormController')->update($recordId, $context);
    }


    /**
     * Adds scripts needed for map coords functionality
     */
    protected function addMapAssets() {
        $this->addCss('/plugins/graker/mapmarkers/assets/css/mapmarkers_map.css');
        //add local map init script and google map script
        $this->addJs('/plugins/graker/mapmarkers/assets/js/markercoords.js');
        $this->addJs('/plugins/graker/mapmarkers/assets/js/checkboxlist-searchable.js');
        $key = (Settings::get('api_key')) ? 'key=' . Settings::get('api_key') . '&' : '';
        $this->addJs(
          'https://maps.googleapis.com/maps/api/js?' . $key . 'callback=markerCoordsMapInit',
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
     * @return string json
     */
    public function onMarkersLoad() {
        $markers = Marker::all();
        return $markers->toJson();
    }

}
