<?php namespace Graker\Mapmarkers\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Graker\MapMarkers\Models\Marker;
use Illuminate\Database\Eloquent\Collection;
use Redirect;

class MarkersList extends ComponentBase
{

  /**
   * @var Collection of markers to display
   */
  public $markers;


  /**
   * @var int current page number
   */
  public $currentPage;


  /**
   * @var int last page number
   */
  public $lastPage;


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
      'markersOnPage' => [
        'title'             => 'Markers on page',
        'description'       => 'Amount of markers on one page (to use in pagination)',
        'default'           => 10,
        'type'              => 'string',
        'validationMessage' => 'Markers on page value must be a number',
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
   * Get marker page number from query
   *
   * @return bool
   */
  protected function setCurrentPage() {
    if (isset($_GET['page'])) {
      if (ctype_digit($_GET['page']) && ($_GET['page'] > 0)) {
        $this->currentPage = $_GET['page'];
      } else {
        return FALSE;
      }
    } else {
      $this->currentPage = 1;
    }
    return TRUE;
  }


  /**
   * onRum implementation
   * Setup pager
   * Load markers
   */
  public function onRun() {
    if (!$this->setCurrentPage()) {
      return Redirect::to($this->currentPageUrl() . '?page=1');
    }
    $this->markers = $this->loadMarkers();
    $this->lastPage = $this->markers->lastPage();
    //if current page is greater than number of pages, redirect to the last page
    if ($this->currentPage > $this->lastPage) {
      return Redirect::to($this->currentPageUrl() . '?page=' . $this->lastPage);
    }
  }
  
  
  /**
   * 
   * Returns collection of markers ordered by creation date backwards
   * 
   * @return Collection
   */
  public function loadMarkers() {
    $markers = Marker::orderBy('created_at', 'desc')
      ->with('image')
      ->with('posts')
      ->with('albums')
      ->paginate($this->property('markersOnPage'), $this->currentPage);
    
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
