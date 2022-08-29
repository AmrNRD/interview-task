<?php

namespace App\Module\Cart\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Module\Cart\Entities\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Module\Cart\Database\Factories\CartItemFactory;
use Spatie\QueryBuilder\AllowedFilter;



use \App\Module\Cart\Entities\Cart;
use \App\Module\Product\Entities\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * App\Module\Cart\Entities\CartItem.
 *
 * @OA\Schema(
 *      schema="CartItem",
 *      required={},
 *      @OA\Property(
 *          property="cart_id",
 *          description="Cart id",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="Product id",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
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
 * @property int $cart_id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $deleted_at

 * @property-read Cart|null $cart
 * @property-read Product|null $product


 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at

 * @method static \App\Module\Cart\Database\Factories\CartItemFactory factory(...$parameters)

 * @method static CartItem|null find(integer $id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()

 * @method static \Illuminate\Database\Query\Builder|CartItem onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|CartItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CartItem withoutTrashed()
 * @mixin \Eloquent
 */
class CartItem extends Model
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
    protected static $logName = 'CartItem';

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
        'cart_id',
        'product_id',
        'quantity'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cart_id' =>'integer',
        'product_id' =>'integer',

    ];


    public $translatable = [

    ];

    public static $allowedFilters = [
        'cart_id',
        'product_id'
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
        'cart',
        'product'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "cart_items";

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(){
        return CartItemFactory::new();
    }

    //<editor-fold desc="CartItem Relations" defaultstate="collapsed">
    public function cart():BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    //</editor-fold>

}
