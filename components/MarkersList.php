<?php namespace Graker\Mapmarkers\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Graker\MapMarkers\Models\Marker;
use Illuminate\Database\Eloquent\Collection;

class MarkersList extends ComponentBase
{

  public function componentDetails()
  {
    return [
      'name'        => 'Markers List',
      'description' => 'List of existing map markers'
    ];
  }

  public function defineProperties()
  {
    return [
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
   * Returns collection of markers ordered by creation date backwards
   * 
   * @return Collection
   */
  public function markers() {
    $markers = Marker::orderBy('created_at', 'desc')
      ->with('image')
      ->with('posts')
      ->with('albums')
      ->get();
    
    return $this->prepareMarkers($markers);
  }


  /**
   *
   * Prepares markers data for the output
   *  - create image thumbs
   *  - create urls
   *
   * @param Collection $markers
   * @return Collection
   */
  protected function prepareMarkers($markers) {
    foreach ($markers as $marker) {
      if ($marker->image) {
        $marker->image->thumb = $marker->image->getThumb(120, 120, ['mode' => 'auto']);
      }

      //setup urls for posts and albums
      if ($marker->posts) {
        foreach ($marker->posts as $post) {
          $post->setUrl($this->property('postPage'), $this->controller);
        }
      }
      if ($marker->albums) {
        foreach ($marker->albums as $album) {
          $album->setUrl($this->property('albumPage'), $this->controller);
        }
      }
    }

    return $markers;
  }

}
