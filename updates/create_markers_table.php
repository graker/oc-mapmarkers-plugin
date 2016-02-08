<?php namespace Graker\MapMarkers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMarkersTable extends Migration
{

    public function up()
    {
        Schema::create('graker_mapmarkers_markers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graker_mapmarkers_markers');
    }

}
