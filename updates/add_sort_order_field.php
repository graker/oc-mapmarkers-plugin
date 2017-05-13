<?php namespace Graker\MapMarkers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Graker\MapMarkers\Models\Marker;

class AddSortOrder extends Migration
{

    public function up()
    {
        Schema::table('graker_mapmarkers_markers', function($table)
        {
            $table->integer('sort_order')->unsigned()->nullable();
        });

        // fill sort_order values for existing markers
        foreach (Marker::all() as $marker) {
            $marker->sort_order = $marker->id;
            $marker->save();
        }
    }

    public function down()
    {
        Schema::table('graker_mapmarkers_markers', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }

}
