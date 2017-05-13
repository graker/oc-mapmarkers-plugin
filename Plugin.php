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
          'name'        => 'graker.mapmarkers::lang.plugin.name',
          'description' => 'graker.mapmarkers::lang.plugin.description',
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
            'label' => 'graker.mapmarkers::lang.plugin.manage_permission',
            'tab' => 'graker.mapmarkers::lang.plugin.name',
          ],
          'graker.mapmarkers.access_settings' => [
            'label' => 'graker.mapmarkers::lang.plugin.access_permission',
            'tab' => 'graker.mapmarkers::lang.plugin.name',
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
            'label'       => 'graker.mapmarkers::lang.plugin.name',
            'description' => 'graker.mapmarkers::lang.plugin.settings_description',
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
            'label' => 'graker.mapmarkers::lang.plugin.name',
            'url' => Backend::url('graker/mapmarkers/markers'),
            'icon'        => 'icon-map-marker',
            'permissions' => ['graker.mapmarkers.manage_markers'],
            'order'       => 500,

            'sideMenu' => [
              'new_marker' => [
                'label'       => 'graker.mapmarkers::lang.plugin.new_marker',
                'icon'        => 'icon-plus',
                'url'         => Backend::url('graker/mapmarkers/markers/create'),
                'permissions' => ['graker.mapmarkers.manage_markers'],
              ],
              'markers' => [
                'label'       => 'graker.mapmarkers::lang.plugin.markers',
                'icon'        => 'icon-copy',
                'url'         => Backend::url('graker/mapmarkers/markers'),
                'permissions' => ['graker.mapmarkers.manage_markers'],
              ],
            ],
          ],
        ];
    }

}
