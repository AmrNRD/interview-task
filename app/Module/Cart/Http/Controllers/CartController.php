<?php

namespace App\Module\Cart\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Module\Cart\Http\Requests\Cart\CartStoreFormRequest;
use App\Module\Cart\Http\Requests\Cart\CartUpdateFormRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Traits\Responder;
use App\Module\Cart\Entities\Cart;
use App\Module\Cart\Http\Resources\Cart\CartResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Module\User\Entities\User;




/**
 * Class CartController
 */
class CartController extends Controller
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'Cart';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'Cart';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Carts';

    public function __construct(){
    }

    /**
     * @OA\Get(
     *      path="/carts?include=user&cartItems",
     *      summary="getCartList",
     *      tags={"Cart"},
     *      description="Get all Cart",
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="carts",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Cart")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request){

        $index = QueryBuilder::for(Cart::class)
                    ->allowedFilters(Cart::getFilters())
					->allowedIncludes(Cart::$includes);
		    if($request->has('page')){
		        $index=$index->paginate();
		    }else{
		    	$index=$index->get();
		    }
        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Cart'),"alias"=>$this->moduleAlias,
            "carts"=>CartResource::Collection($index)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.index"
        ];

	    if($request->has('page')){
		     $prams['currentPage']=$index->currentPage();
		     $prams['total']=$index->lastPage();
		}

        return $this->response($prams);
    }

    /*
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function create(){

		$users= User::all();

        $prams=[
            "data"=>["title"=> __('main.add') . ' ' . __('main.Cart'),"alias"=>$this->moduleAlias,
            'users'=> $users,],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Post(
     *      path="/carts",
     *      summary="createCart",
     *      tags={"Cart"},
     *      description="Create Cart",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Cart")
     *      ),
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="cart",
     *                  ref="#/components/schemas/Cart"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * Store a newly created resource in storage.
     *
     * @param  CartStoreFormRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(CartStoreFormRequest $request){
        $store = Cart::create($request->validated());

        if($store){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Cart'),"alias"=>$this->moduleAlias,
            "cart"=>new CartResource($store)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$store->id]]
        ];

        }else{

        $prams=[
            "data"=>["message"=>"Create failed"],
            "response_code"=>422,
            "redirectBack"=>true
        ];

        }
        return $this->response($prams);
    }

    /**
     * @OA\Get(
     *      path="/carts/{id}",
     *      summary="getCartItem",
     *      tags={"Cart"},
     *      description="Get Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
     *           @OA\Schema(
     *             type="number"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="cart",
     *                  ref="#/components/schemas/Cart"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * Display the specified resource.
     *
     * @param  Cart   $cart
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(Cart $cart){
        $prams=[
            "data"=>[
            "title"=>  __('main.show') . ' ' .  __('main.Cart') . ' : ' . $cart->id,
            "alias"=>$this->moduleAlias,"cart"=>new CartResource($cart)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.show"
        ];

        return $this->response($prams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cart   $cart
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function edit(Cart  $cart){

		$users= User::all();


        $prams=[
            "data"=>[
            "title"=> __('main.edit') . ' ' . __('main.Cart'),"alias"=>$this->moduleAlias,
            "cart"=>new CartResource($cart),
            'users'=> $users,
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Put(
     *      path="/carts/{id}",
     *      summary="updateCart",
     *      tags={"Cart"},
     *      description="Update Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
     *           @OA\Schema(
     *             type="number"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Cart")
     *      ),
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="cart",
     *                  ref="#/components/schemas/Cart"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * Update the specified resource in storage.
     *
     * @param  CartUpdateFormRequest  $request
     * @param  Cart   $cart
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(CartUpdateFormRequest $request,Cart $cart){
        $update = $cart->update($request->validated());

        if($update){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Cart'),"alias"=>$this->moduleAlias,
            "cart"=>new CartResource($cart)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$cart->id]]
        ];

        }else{

        $prams=[
            "data"=>["message"=>"Update failed"],
            "response_code"=>422,
            "redirectBack"=>true
        ];

        }

        return $this->response($prams);
    }

    /**
     * @OA\Delete(
     *      path="/carts/{id}",
     *      summary="deleteCart",
     *      tags={"Cart"},
     *      description="Delete Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
     *           @OA\Schema(
     *             type="number"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        $ids = request()->get('ids',[$id]);

        $delete = Cart::whereIn('id',$ids)->delete();

        if($delete){
        $prams=[
            "data"=>["message"=>"Deleted Successfully"],
            "response_code"=>200,
            "redirectBack"=>true
         ];
        }else{
        $prams=[
            "data"=>["message"=>"Delete failed"],
            "response_code"=>422,
            "redirectBack"=>true
         ];
        }

        return $this->response($prams);

    }


}
