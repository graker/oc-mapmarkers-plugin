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
      'icon'        => 'icon-map-marker',
      'homepage'    => 'https://github.com/graker/mapmarkers',
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
    return [
      'mapmarkers' => [
        'label' => 'Map Markers',
        'url' => Backend::url('graker/mapmarkers/markers'),
        'icon'        => 'icon-map-marker',
        'permissions' => ['graker.mapmarkers.manage_markers'],
        'order'       => 500,

        'sideMenu' => [
          'new_marker' => [
            'label'       => 'New marker',
            'icon'        => 'icon-plus',
            'url'         => Backend::url('graker/mapmarkers/markers/create'),
            'permissions' => ['graker.mapmarkers.manage_markers'],
          ],
          'markers' => [
            'label'       => 'Markers',
            'icon'        => 'icon-copy',
            'url'         => Backend::url('graker/mapmarkers/markers'),
            'permissions' => ['graker.mapmarkers.manage_markers'],
          ],
        ],
      ],
    ];
  }

}
