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
            'description' => 'No description provided yet...',
            'author'      => 'Graker',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Graker\MapMarkers\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'graker.mapmarkers.some_permission' => [
                'tab' => 'MapMarkers',
                'label' => 'Some permission'
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
