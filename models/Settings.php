<?php

/**
 * MapMarkers settings model
 */

namespace Graker\MapMarkers\Models;

use Model;

class Settings extends Model {

    public $implement = ['System.Behaviors.SettingsModel '];

    /**
     * @var string unique code to access settings
     */
    public $settingsCode = 'mapmarkers_settings';

    /**
     * @var string file with setting fields
     */
    public $settingsFields = 'fields.yaml';

}
