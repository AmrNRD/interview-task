<?php

namespace App\Module\Cart\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Module\Cart\Database\Factories\CartFactory;
use Spatie\QueryBuilder\AllowedFilter;



use App\Module\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
    * App\Module\Cart\Entities\Cart.
    *
 * @OA\Schema(
 *      schema="Cart",
 *      required={},
 *      @OA\Property(
 *          property="user_id",
 *          description="Owner id of the cart",
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
	* @property int $user_id
	* @property \Illuminate\Support\Carbon|null $deleted_at

	* @property-read User|null $user


    * @property \Illuminate\Support\Carbon $created_at
    * @property \Illuminate\Support\Carbon $updated_at

    * @method static \App\Module\Cart\Database\Factories\CartFactory factory(...$parameters)

    * @method static Cart|null find(integer $id = null)
    * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
    * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
    * @method static \Illuminate\Database\Eloquent\Builder|Cart query()

    * @method static \Illuminate\Database\Query\Builder|Cart onlyTrashed()
    * @method static \Illuminate\Database\Query\Builder|Cart withTrashed()
    * @method static \Illuminate\Database\Query\Builder|Cart withoutTrashed()
    * @mixin \Eloquent
    */
class Cart extends Model 
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
    protected static $logName = 'Cart';

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
    'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'user_id' =>'integer',

    ];


    public $translatable = [
    
    ];

    public static $allowedFilters = [
    'user_id'
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
    protected $table = "carts";

   /**
    * Create a new factory instance for the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    protected static function newFactory(){
       return CartFactory::new();
    }

	//<editor-fold desc="Cart Relations" defaultstate="collapsed">
	public function user():BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	//</editor-fold>
}
