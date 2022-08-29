<?php

namespace App\Module\Product\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Module\Product\Database\Factories\ProductFactory;
use Spatie\QueryBuilder\AllowedFilter;



use \App\Module\Store\Entities\Store;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;



/**
 * App\Module\Product\Entities\Product.
 *
 * @OA\Schema(
 *      schema="Product",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="Name of the product",
 *          readOnly=false,
 *          nullable=false,
 *          type="object",
 *      @OA\Property(
 *          property="ar",
 *          description="Arabic Name of the product",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="en",
 *          description="Arabic Name of the product",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      ),
 *      @OA\Property(
 *          property="store_id",
 *          description="Store id",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="price of the product",
 *          readOnly=false,
 *          nullable=false,
 *          type="number",
 *      ),
 *      @OA\Property(
 *          property="vat_included",
 *          description="is vat included in the price of the product",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
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
 * @property array $name
 * @property int $store_id
 * @property float $price
 * @property float $vat_percentage
 * @property float $shipping_cost
 * @property boolean $vat_included
 * @property \Illuminate\Support\Carbon|null $deleted_at

 * @property-read Store|null $store


 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at

 * @method static \App\Module\Product\Database\Factories\ProductFactory factory(...$parameters)

 * @method static Product|null find(integer $id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()

 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Product';

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
        'store_id',
        'price',
        'vat_included'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' =>'array',
        'store_id' =>'integer',
        'price' =>'float',
        'vat_included' =>'boolean',

    ];


    public $translatable = [
        'name'
    ];

    public static $allowedFilters = [
        'name',
        'store_id',
        'price',
        'vat_included'
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
        'store'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "products";

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(){
        return ProductFactory::new();
    }

    //<editor-fold desc="Product Relations" defaultstate="collapsed">
    public function store():BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    //</editor-fold>

    //<editor-fold desc="Product Attributes" defaultstate="collapsed">
    public function getVatPercentageAttribute()
    {
        return $this->vat_included?0:$this->store->vat_percentage??0;
    }
    public function getShippingCostAttribute()
    {
        return $this->store->shipping_cost??0;
    }
    //</editor-fold>
}
