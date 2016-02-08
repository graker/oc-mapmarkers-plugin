<?php namespace Graker\MapMarkers;

use Backend;
use System\Classes\PluginBase;

/**
 * MapMarkers Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'MapMarkers',
            'description' => 'Google map with multiple markers',
            'author'      => 'Graker',
            'icon'        => 'icon-map-marker'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return [
            'Graker\MapMarkers\Components\Map' => 'markersMap',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
      return [
        'graker.mapmarkers.manage_markers' => [
          'label' => 'Manage map markers',
          'tab' => 'Map Markers',
        ],
      ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'mapmarkers' => [
                'label'       => 'MapMarkers',
                'url'         => Backend::url('graker/mapmarkers/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['graker.mapmarkers.*'],
                'order'       => 500,
            ],
        ];
    }

}
