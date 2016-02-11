<?php namespace Graker\MapMarkers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePostMarkersTable extends Migration
{

  public function up()
  {
    Schema::create('graker_mapmarkers_post_markers', function($table)
    {
      $table->integer('post_id')->unsigned();
      $table->integer('marker_id')->unsigned();
      $table->primary(['post_id', 'marker_id']);
    });
  }

  public function down()
  {
    Schema::dropIfExists('graker_mapmarkers_post_markers');
  }

}
