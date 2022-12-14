<?php

namespace App\Infrastructure\AbstractModels;

use App\Infrastructure\Traits\DateScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;


abstract class BaseModel extends Model
{
    use DateScopeTrait;
    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * define HasOne relations.
     *
     * @var array
     */
    private $hasOne = [];

    /**
     * define MorphTo relations.
     *
     * @var boolean
     */
    private $morphTo = false;

    /**
     * define MorphTo relations.
     *
     * @var array
     */
    private $morphOne = [];

    /**
     * define MorphMany relations.
     *
     * @var array
     */
    private $morphMany = [];

    /**
     * define morphToMany relations.
     *
     * @var array
     */
    private $morphToMany = [];

    /**
     * define morphedByMany relations.
     *
     * @var array
     */
    private $morphedByMany = [];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = null;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = null;


    /**
     *
     * @var array
     */
    public static $allowedFilters = [];

    /**
     *
     * @var array
     */
    public static $allowedFilersExact= [];

    /**
     *
     * @var array
     */
    public static $allowedFilersScope= [
        'date_starts_before',
        'date_ends_before',
        'date_in_between',
        'by_date',
    ];

    /**
     *
     * @var array
     */
    public static $includes= [

    ];


    /**
     * Reolve Route Binding Using Repo
     *
     * @param string $value
     * @param mix $field
     * @return mix
     */
    public function resolveRouteBinding($value, $field = null){
        if($this->routeRepoBinding){
            $repo = app()->make($this->routeRepoBinding);
            return $repo->findWhere( [$this->getRouteKeyName()=> $value])->first() ?? abort(404);
        }else{
            return $this->where('id',$value)->first() ?? abort(404);
        }
    }

    public static function getFilters(){
        $filters=self::$allowedFilters;
        foreach(self::$allowedFilersExact as $filter){
            array_push($filters,AllowedFilter::exact($filter));
        }
        foreach(self::$allowedFilersScope as $filter){
            array_push($filters,AllowedFilter::scope($filter));
        }
        return $filters;
    }
}
