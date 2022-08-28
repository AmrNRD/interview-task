<?php

namespace App\Module\Store\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Module\Store\Http\Requests\Store\StoreStoreFormRequest;
use App\Module\Store\Http\Requests\Store\StoreUpdateFormRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Traits\Responder;
use App\Module\Store\Entities\Store;
use App\Module\Store\Http\Resources\Store\StoreResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Module\User\Entities\User;




/**
 * Class StoreController
 */
class StoreController extends Controller
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'Store';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'Store';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Stores';

    public function __construct(){
     $this->authorizeResource(Store::class, "store");
    }

    /**
     * @OA\Get(
     *      path="/stores",
     *      summary="getStoreList",
     *      tags={"Store"},
     *      description="Get all Store",
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
     *                  property="stores",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Store")
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

        $index = QueryBuilder::for(Store::class)
                    ->allowedFilters(Store::getFilters())
					->allowedIncludes(Store::$includes);
		    if($request->has('page')){
		        $index=$index->paginate();
		    }else{
		    	$index=$index->get();
		    }
        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Store'),"alias"=>$this->moduleAlias,
            "stores"=>StoreResource::Collection($index)
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
            "data"=>["title"=> __('main.add') . ' ' . __('main.Store'),"alias"=>$this->moduleAlias,
            'users'=> $users,],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Post(
     *      path="/stores",
     *      summary="createStore",
     *      tags={"Store"},
     *      description="Create Store",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Store")
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
     *                  property="store",
     *                  ref="#/components/schemas/Store"
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
     * @param  StoreStoreFormRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreStoreFormRequest $request){
        $store = Store::create($request->validated());

        if($store){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Store'),"alias"=>$this->moduleAlias,
            "store"=>new StoreResource($store)
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
     *      path="/stores/{id}",
     *      summary="getStoreItem",
     *      tags={"Store"},
     *      description="Get Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
     *           @OA\Schema(
     *             type="integer"
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
     *                  property="store",
     *                  ref="#/components/schemas/Store"
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
     * @param  Store   $store
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(Store $store){
        $prams=[
            "data"=>[
            "title"=>  __('main.show') . ' ' .  __('main.Store') . ' : ' . $store->id,
            "alias"=>$this->moduleAlias,"store"=>new StoreResource($store)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.show"
        ];

        return $this->response($prams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Store   $store
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function edit(Store  $store){

		$users= User::all();


        $prams=[
            "data"=>[
            "title"=> __('main.edit') . ' ' . __('main.Store'),"alias"=>$this->moduleAlias,
            "store"=>new StoreResource($store),
            'users'=> $users,
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Put(
     *      path="/stores/{id}",
     *      summary="updateStore",
     *      tags={"Store"},
     *      description="Update Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Store")
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
     *                  property="store",
     *                  ref="#/components/schemas/Store"
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
     * @param  StoreUpdateFormRequest  $request
     * @param  Store   $store
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdateFormRequest $request,Store $store){
        $update = $store->update($request->validated());

        if($update){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.Store'),"alias"=>$this->moduleAlias,
            "store"=>new StoreResource($store)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$store->id]]
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
     *      path="/stores/{id}",
     *      summary="deleteStore",
     *      tags={"Store"},
     *      description="Delete Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
     *           @OA\Schema(
     *             type="integer"
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

        $delete = Store::whereIn('id',$ids)->delete();

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
