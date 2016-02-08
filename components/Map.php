<?php namespace Graker\MapMarkers\Components;

use Cms\Classes\ComponentBase;
use Graker\MapMarkers\Models\Marker;

class Map extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Map',
            'description' => 'Google map with markers'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

}
