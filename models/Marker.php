<?php namespace Graker\MapMarkers\Models;

use Model;

/**
 * Marker Model
 */
class Marker extends Model
{

  use \October\Rain\Database\Traits\Validation;

  /**
   * @var string The database table used by the model.
   */
  public $table = 'graker_mapmarkers_markers';

  /**
   * @var array Validation rules
   */
  public $rules = [
    'title' => 'required',
    'latitude' => 'required',
    'longitude' => 'required',
  ];

  /**
   * @var array Guarded fields
   */
  protected $guarded = ['*'];

  /**
   * @var array Fillable fields
   */
  protected $fillable = [];

  /**
   * @var array Relations
   */

  public $belongsTo = [
    'user' => ['Backend\Models\User'],
  ];

  public $belongsToMany = [
    'posts' => [
      'RainLab\Blog\Models\Post',
      'table' => 'graker_mapmarkers_post_markers',
    ],
    'albums' => [
      'Graker\PhotoAlbums\Models\Album',
      'table' => 'graker_mapmarkers_album_markers',
    ],
  ];


  public $attachOne = [
    'image' => ['System\Models\File'],
  ];


  /**
   *
   * Generates thumbnail for the marker by picking one of existing thumbs in following priority:
   *  1) Image attached directly to marker
   *  2) Featured image of attached post
   *  3) Latest photo in attached album
   *
   * @param array of thumb options (width, height, mode)
   * @return string
   */
  public function getMarkerThumb($options) {
    // check attached image
    if ($this->image) {
      return $this->image->getThumb(
        $options['width'],
        $options['height'],
        ['mode' => $options['mode']]
      );
    }

    // check posts
    if ($this->posts) {
      foreach ($this->posts as $post) {
        if ($featured_image = $post->featured_images->first()) {
          return $featured_image->getThumb(
            $options['width'],
            $options['height'],
            ['mode' => $options['mode']]
          );
        }
      }
    }

    // check albums
    if ($this->albums) {
      foreach ($this->albums as $album) {
        if ($album->latestPhoto && ($photo = $album->latestPhoto->image)) {
          return $photo->getThumb(
            $options['width'],
            $options['height'],
            ['mode' => $options['mode']]
          );
        }
      }
    }

    return '';
  }

}
