<?php

namespace App\Module\Cart\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Module\Cart\Http\Requests\CartItem\CartItemStoreFormRequest;
use App\Module\Cart\Http\Requests\CartItem\CartItemUpdateFormRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Traits\Responder;
use App\Module\Cart\Entities\CartItem;
use App\Module\Cart\Http\Resources\CartItem\CartItemResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use \App\Module\Cart\Entities\Cart;
use \App\Module\Product\Entities\Product;




/**
 * Class CartItemController
 */
class CartItemController extends Controller
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'CartItem';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'CartItem';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Carts';

    public function __construct(){
     $this->authorizeResource(CartItem::class, "cart_item");
    }

    /**
     * @OA\Get(
     *      path="/cart-items",
     *      summary="getCartItemList",
     *      tags={"CartItem"},
     *      description="Get all CartItem",
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
     *                  property="cartItems",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/CartItem")
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

        $index = QueryBuilder::for(CartItem::class)
                    ->allowedFilters(CartItem::getFilters())
					->allowedIncludes(CartItem::$includes);
		    if($request->has('page')){
		        $index=$index->paginate();
		    }else{
		    	$index=$index->get();
		    }
        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.CartItem'),"alias"=>$this->moduleAlias,
            "cartItems"=>CartItemResource::Collection($index)
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

		$carts= Cart::all();

		$products= Product::all();

        $prams=[
            "data"=>["title"=> __('main.add') . ' ' . __('main.CartItem'),"alias"=>$this->moduleAlias,
            'carts'=> $carts,'products'=> $products,],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Post(
     *      path="/cart-items",
     *      summary="createCartItem",
     *      tags={"CartItem"},
     *      description="Create CartItem",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CartItem")
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
     *                  property="cartItem",
     *                  ref="#/components/schemas/CartItem"
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
     * @param  CartItemStoreFormRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(CartItemStoreFormRequest $request){
        $store = CartItem::create($request->validated());

        if($store){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.CartItem'),"alias"=>$this->moduleAlias,
            "cartItem"=>new CartItemResource($store)
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
     *      path="/cart-items/{id}",
     *      summary="getCartItemItem",
     *      tags={"CartItem"},
     *      description="Get CartItem",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CartItem",
     *           @OA\Schema(
     *             type="{{ID_TYPE}}"
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
     *                  property="cartItem",
     *                  ref="#/components/schemas/CartItem"
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
     * @param  CartItem   $cartItem
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(CartItem $cartItem){
        $prams=[
            "data"=>[
            "title"=>  __('main.show') . ' ' .  __('main.CartItem') . ' : ' . $cartItem->id,
            "alias"=>$this->moduleAlias,"cartItem"=>new CartItemResource($cartItem)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.show"
        ];

        return $this->response($prams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CartItem   $cartItem
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function edit(CartItem  $cartItem){

		$carts= Cart::all();

		$products= Product::all();


        $prams=[
            "data"=>[
            "title"=> __('main.edit') . ' ' . __('main.CartItem'),"alias"=>$this->moduleAlias,
            "cartItem"=>new CartItemResource($cartItem),
            'carts'=> $carts,'products'=> $products,
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Put(
     *      path="/cart-items/{id}",
     *      summary="updateCartItem",
     *      tags={"CartItem"},
     *      description="Update CartItem",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CartItem",
     *           @OA\Schema(
     *             type="{{ID_TYPE}}"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CartItem")
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
     *                  property="cartItem",
     *                  ref="#/components/schemas/CartItem"
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
     * @param  CartItemUpdateFormRequest  $request
     * @param  CartItem   $cartItem
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(CartItemUpdateFormRequest $request,CartItem $cartItem){
        $update = $cartItem->update($request->validated());

        if($update){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.CartItem'),"alias"=>$this->moduleAlias,
            "cartItem"=>new CartItemResource($cartItem)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$cartItem->id]]
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
     *      path="/cart-items/{id}",
     *      summary="deleteCartItem",
     *      tags={"CartItem"},
     *      description="Delete CartItem",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CartItem",
     *           @OA\Schema(
     *             type="{{ID_TYPE}}"
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

        $delete = CartItem::whereIn('id',$ids)->delete();

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
