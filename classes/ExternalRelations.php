<?php namespace Graker\MapMarkers\Classes;

use System\Classes\PluginManager;

class ExternalRelations
{

    /**
     *
     * Returns TRUE if plugin with id provided exists and is not disabled
     *
     * @param string $id
     * @return bool
     */
    public static function isPluginAvailable($id) {
        $plugin_manager = PluginManager::instance();
        return ($plugin_manager->hasPlugin($id) && !$plugin_manager->isDisabled($id));
    }

}
