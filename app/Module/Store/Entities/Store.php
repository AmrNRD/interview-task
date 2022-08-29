<?php

namespace App\Module\Store\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Module\Store\Database\Factories\StoreFactory;
use Spatie\QueryBuilder\AllowedFilter;



use App\Module\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * App\Module\Store\Entities\Store.
 *
 * @OA\Schema(
 *      schema="Store",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="Name of the store",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="Owner id of the store",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="shipping_cost",
 *          description="Optional shipping cost",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *      ),
 *      @OA\Property(
 *          property="vat_percentage",
 *          description="Optional VAT on store product",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *      ),

 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="deleted_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * ))
 * @property int id
 * @property string $name
 * @property int $user_id
 * @property float|null $shipping_cost
 * @property float|null $vat_percentage
 * @property \Illuminate\Support\Carbon|null $deleted_at

 * @property-read User|null $user


 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at

 * @method static \App\Module\Store\Database\Factories\StoreFactory factory(...$parameters)

 * @method static Store|null find(integer $id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()

 * @method static \Illuminate\Database\Query\Builder|Store onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Store withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Store withoutTrashed()
 * @mixin \Eloquent
 */
class Store extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Store';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'shipping_cost',
        'vat_cost'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' =>'integer',
        'shipping_cost' =>'float',
        'vat_percentage' =>'float',

    ];


    public $translatable = [

    ];

    public static $allowedFilters = [
        'name',
        'user_id',
        'shipping_cost',
        'vat_percentage'
    ];

    public static $allowedFilersExact= [
        'id',
    ];

    public static $allowedFilersScope= [
        'date_starts_before',
        'date_ends_before',
        'date_in_between',
        'by_date',
    ];

    public static $includes = [
        'user'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "stores";

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(){
        return StoreFactory::new();
    }

    //<editor-fold desc="Store Relations" defaultstate="collapsed">
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //</editor-fold>
}
