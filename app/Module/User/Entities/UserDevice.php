<?php

namespace App\Module\User\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Module\User\Database\Factories\UserDeviceFactory;
use Spatie\QueryBuilder\AllowedFilter;



use App\Module\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



/**
    * App\Module\User\Entities\UserDevice.
    *
 * @OA\Schema(
 *      schema="UserDevice",
 *      required={},
 *      @OA\Property(
 *          property="fcm_token",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
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
 * ))
	* @property int id
	* @property string $fcm_token
	* @property mixed $type
	* @property string $user_id

	* @property-read User|null $user


    * @property \Illuminate\Support\Carbon $created_at
    * @property \Illuminate\Support\Carbon $updated_at

    * @method static \App\Module\User\Database\Factories\UserDeviceFactory factory(...$parameters)

    * @method static UserDevice|null find(integer $id = null)
    * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newModelQuery()
    * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newQuery()
    * @method static \Illuminate\Database\Eloquent\Builder|UserDevice query()

    * @method static \Illuminate\Database\Query\Builder|UserDevice onlyTrashed()
    * @method static \Illuminate\Database\Query\Builder|UserDevice withTrashed()
    * @method static \Illuminate\Database\Query\Builder|UserDevice withoutTrashed()
    * @mixin \Eloquent
    */
class UserDevice extends Model 
{
    use HasFactory;
    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'UserDevice';

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
    'fcm_token',
	'type',
	'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    
    ];


    public $translatable = [
    
    ];

    public static $allowedFilters = [
    'fcm_token',
	'type',
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
    protected $table = "user_devices";

   /**
    * Create a new factory instance for the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    protected static function newFactory(){
       return UserDeviceFactory::new();
    }

	//<editor-fold desc="UserDevice Relations" defaultstate="collapsed">
	public function user():BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	//</editor-fold>
}
