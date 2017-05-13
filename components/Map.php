<?php namespace Graker\MapMarkers\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Graker\MapMarkers\Models\Marker;
use Illuminate\Database\Eloquent\Collection;
use Request;
use Graker\MapMarkers\Models\Settings;

class Map extends ComponentBase
{

    public function componentDetails() {
        return [
          'name'        => 'Map',
          'description' => 'Google map with markers'
        ];
    }


    /**
     *
     * Define component properties
     *
     * @return array
     */
    public function defineProperties() {
        return [
          'centerLat' => [
            'title'       => 'Center latitude',
            'description' => 'Latitude of map center (float)',
            'type'        => 'string',
            'default'     => 0.0,
          ],
          'centerLng' => [
            'title'       => 'Center longitude',
            'description' => 'Longitude of map center (float)',
            'type'        => 'string',
            'default'     => 0.0,
          ],
          'zoom' => [
            'title'       => 'Default zoom',
            'description' => 'Map zoom by default',
            'type'        => 'string',
            'default'     => 2,
          ],
          'mapMarker' => [
            'title'       => 'Icon path',
            'description' => 'Path to custom marker icon',
            'default'     => '',
            'type'        => 'string',
            'group'       => 'Marker icon',
          ],
          'iconXOffset' => [
            'title'             => 'X offset',
            'description'       => 'X offset to anchor the icon',
            'default'           => 0,
            'type'              => 'string',
            'validationMessage' => 'X offset must be a number',
            'validationPattern' => '^[0-9]+$',
            'group'             => 'Marker icon',
          ],
          'iconYOffset' => [
            'title'             => 'Y offset',
            'description'       => 'Y offset to anchor the icon',
            'default'           => 0,
            'type'              => 'string',
            'validationMessage' => 'Y offset must be a number',
            'validationPattern' => '^[0-9]+$',
            'group'             => 'Marker icon',
          ],
          'thumbMode' => [
            'title'       => 'Thumb mode',
            'description' => 'Mode of thumb generation',
            'type'        => 'dropdown',
            'default'     => 'auto',
          ],
          'thumbWidth' => [
            'title'             => 'Thumb width',
            'description'       => 'Width of the thumb to be generated',
            'default'           => 640,
            'type'              => 'string',
            'validationMessage' => 'Thumb width must be a number',
            'validationPattern' => '^[0-9]+$',
            'required'          => FALSE,
          ],
          'thumbHeight' => [
            'title'             => 'Thumb height',
            'description'       => 'Height of the thumb to be generated',
            'default'           => 480,
            'type'              => 'string',
            'validationMessage' => 'Thumb height must be a number',
            'validationPattern' => '^[0-9]+$',
            'required'          => FALSE,
          ],
          'postPage' => [
            'title'       => 'Blog post page',
            'description' => 'Page used to display blog posts',
            'type'        => 'dropdown',
            'default'     => 'blog/post',
          ],
          'albumPage' => [
            'title'       => 'Album page',
            'description' => 'Page used to display photo albums',
            'type'        => 'dropdown',
            'default'     => 'photoalbums/album',
          ],
        ];
    }


    /**
     *
     * Returns pages list for album page select box setting
     *
     * @return mixed
     */
    public function getAlbumPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }


    /**
     *
     * Returns pages list for album page select box setting
     *
     * @return mixed
     */
    public function getPostPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }


    /**
     *
     * Returns thumb resize mode options for thumb mode select box setting
     *
     * @return array
     */
    public function getThumbModeOptions() {
        return [
          'auto' => 'Auto',
          'exact' => 'Exact',
          'portrait' => 'Portrait',
          'landscape' => 'Landscape',
          'crop' => 'Crop',
        ];
    }


    /**
     * Adds scripts needed for map functionality
     */
    protected function addMapAssets() {
        //add default styles for map
        $this->addCss('/plugins/graker/mapmarkers/assets/css/mapmarkers_map.css');

        //add local map init script and google map script
        $this->addJs('/plugins/graker/mapmarkers/assets/js/mapmarkers_map.js');

        //add google map js with or without api key
        $key = (Settings::get('api_key')) ? 'key=' . Settings::get('api_key') . '&' : '';
        $this->addJs(
          'https://maps.googleapis.com/maps/api/js?' . $key . 'callback=mapComponentInit',
          [
            'async',
            'defer',
          ]
        );
    }


    /**
     * onRun event
     */
    public function onRun() {
        $this->addMapAssets();
    }


    /**
     *
     * Returns JSON with all data needed:
     *  - .settings - global map settings (marker icon)
     *  - .markers - markers data: title and coordinates
     *
     * @return string json
     */
    public function onDataLoad() {
        $data = array();
        $data['settings'] = $this->createSettingsArray();
        $markers = $this->loadMarkers();
        $data['markers'] = $markers->toArray();
        return json_encode($data);
    }


    /**
     * @return Collection of all markers
     */
    protected function loadMarkers() {
        $markers = Marker::all();
        return $markers;
    }


    /**
     *
     * Creates array of settings to pass to JS as JSON
     *
     * @return array
     */
    protected function createSettingsArray() {
        $settings = array();
        $settings['image'] = $this->property('mapMarker');
        $settings['x_offset'] = $this->property('iconXOffset');
        $settings['y_offset'] = $this->property('iconYOffset');
        $settings['zoom'] = $this->property('zoom');
        $settings['center'] = [
          'lat' => $this->property('centerLat'),
          'lng' => $this->property('centerLng'),
        ];
        return $settings;
    }


    /**
     *
     * Renders info box in response to marker's click
     *
     * @return string
     */
    public function onMarkerClicked() {
        $id = Request::input('marker_id');
        $model = Marker::where('id', $id)
          ->with('posts')
          ->with(['albums' => function ($query) {
              $query->with('latestPhoto');
          }])
          ->with('image')
          ->first();

        $model->thumb = $model->getMarkerThumb([
          'width' => $this->property('thumbWidth'),
          'height' => $this->property('thumbHeight'),
          'mode' => $this->property('thumbMode'),
        ]);

        //setup urls for posts and albums
        if ($model->posts) {
            foreach ($model->posts as $post) {
                $post->setUrl($this->property('postPage'), $this->controller);
            }
        }
        if ($model->albums) {
            foreach ($model->albums as $album) {
                $album->setUrl($this->property('albumPage'), $this->controller);
            }
        }

        $model->singleUrl = $this->getSingleUrl($model);

        return $this->renderPartial('::popup', ['marker' => $model]);
    }


    /**
     *
     * Returns single url for a marker given, if it has exactly one attachment
     * or returns '' if there more than one attachment or none at all
     *
     * @param \Graker\MapMarkers\Models\Marker $marker
     * @return string
     */
    protected function getSingleUrl(Marker $marker) {
        $url = '';

        $posts_count = count($marker->posts);
        $markers_count = count($marker->albums);
        if (($posts_count + $markers_count) == 1) {
            if ($posts_count) {
                $url = $marker->posts->first()->url;
            } else {
                $url = $marker->albums->first()->url;
            }
        }

        return $url;
    }

}
