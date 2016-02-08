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
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}