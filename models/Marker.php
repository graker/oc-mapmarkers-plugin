<?php namespace Graker\MapMarkers\Models;

use Model;

/**
 * Marker Model
 */
class Marker extends Model
{

  /**
   * @var string The database table used by the model.
   */
  public $table = 'graker_mapmarkers_markers';

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
      'graker_mapmarkers_post_markers',
    ],
    'albums' => [
      'Graker\PhotoAlbums\Models\Album',
      'graker_mapmarkers_album_markers',
    ],
  ];


  public $attachOne = [
    'image' => ['System\Models\File'],
  ];

}
