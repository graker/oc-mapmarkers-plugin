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
      'Graker\MapMarkers\Components\MarkersList' => 'markersList',
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
      'graker.mapmarkers.access_settings' => [
        'label' => 'Access Settings',
        'tab' => 'Map Markers',
      ],
    ];
  }
  
  
  /**
   *
   * Registers plugin's settings
   *
   * @return array
   */
  public function registerSettings()
  {
    return [
      'settings' => [
        'label'       => 'MapMarkers',
        'description' => 'Manage MapMarkers Settings.',
        'icon'        => 'icon-map-marker',
        'class'       => 'Graker\MapMarkers\Models\Settings',
        'order'       => 100,
        'permissions' => ['graker.mapmarkers.access_settings'],
      ]
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
