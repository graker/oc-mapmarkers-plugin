<?php namespace Graker\MapMarkers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAlbumMarkersTable extends Migration
{

  public function up()
  {
    Schema::create('graker_mapmarkers_album_markers', function($table)
    {
      $table->integer('album_id')->unsigned();
      $table->integer('marker_id')->unsigned();
      $table->primary(['album_id', 'marker_id']);
    });
  }

  public function down()
  {
    Schema::dropIfExists('graker_mapmarkers_album_markers');
  }

}
