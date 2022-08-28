<?php

namespace App\Module\User\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Module\User\Http\Requests\UserDevice\UserDeviceStoreFormRequest;
use App\Module\User\Http\Requests\UserDevice\UserDeviceUpdateFormRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Traits\Responder;
use App\Module\User\Entities\UserDevice;
use App\Module\User\Http\Resources\UserDevice\UserDeviceResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Module\User\Entities\User;




/**
 * Class UserDeviceController
 */
class UserDeviceController extends Controller
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'UserDevice';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'UserDevice';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Users';

    public function __construct(){
     $this->authorizeResource(UserDevice::class, "user_device");
    }

    /**
     * @OA\Get(
     *      path="/user-devices",
     *      summary="getUserDeviceList",
     *      tags={"UserDevice"},
     *      description="Get all UserDevice",
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
     *                  property="userDevices",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/UserDevice")
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

        $index = QueryBuilder::for(UserDevice::class)
                    ->allowedFilters(UserDevice::getFilters())
					->allowedIncludes(UserDevice::$includes);
		    if($request->has('page')){
		        $index=$index->paginate();
		    }else{
		    	$index=$index->get();
		    }
        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.UserDevice'),"alias"=>$this->moduleAlias,
            "userDevices"=>UserDeviceResource::Collection($index)
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
            "data"=>["title"=> __('main.add') . ' ' . __('main.UserDevice'),"alias"=>$this->moduleAlias,
            'users'=> $users,],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Post(
     *      path="/user-devices",
     *      summary="createUserDevice",
     *      tags={"UserDevice"},
     *      description="Create UserDevice",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/UserDevice")
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
     *                  property="userDevice",
     *                  ref="#/components/schemas/UserDevice"
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
     * @param  UserDeviceStoreFormRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(UserDeviceStoreFormRequest $request){
        $store = UserDevice::create($request->validated());

        if($store){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.UserDevice'),"alias"=>$this->moduleAlias,
            "userDevice"=>new UserDeviceResource($store)
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
     *      path="/user-devices/{id}",
     *      summary="getUserDeviceItem",
     *      tags={"UserDevice"},
     *      description="Get UserDevice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of UserDevice",
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
     *                  property="userDevice",
     *                  ref="#/components/schemas/UserDevice"
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
     * @param  UserDevice   $userDevice
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(UserDevice $userDevice){
        $prams=[
            "data"=>[
            "title"=>  __('main.show') . ' ' .  __('main.UserDevice') . ' : ' . $userDevice->id,
            "alias"=>$this->moduleAlias,"userDevice"=>new UserDeviceResource($userDevice)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.show"
        ];

        return $this->response($prams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserDevice   $userDevice
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function edit(UserDevice  $userDevice){

		$users= User::all();


        $prams=[
            "data"=>[
            "title"=> __('main.edit') . ' ' . __('main.UserDevice'),"alias"=>$this->moduleAlias,
            "userDevice"=>new UserDeviceResource($userDevice),
            'users'=> $users,
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Put(
     *      path="/user-devices/{id}",
     *      summary="updateUserDevice",
     *      tags={"UserDevice"},
     *      description="Update UserDevice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of UserDevice",
     *           @OA\Schema(
     *             type="{{ID_TYPE}}"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/UserDevice")
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
     *                  property="userDevice",
     *                  ref="#/components/schemas/UserDevice"
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
     * @param  UserDeviceUpdateFormRequest  $request
     * @param  UserDevice   $userDevice
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UserDeviceUpdateFormRequest $request,UserDevice $userDevice){
        $update = $userDevice->update($request->validated());

        if($update){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.UserDevice'),"alias"=>$this->moduleAlias,
            "userDevice"=>new UserDeviceResource($userDevice)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$userDevice->id]]
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
     *      path="/user-devices/{id}",
     *      summary="deleteUserDevice",
     *      tags={"UserDevice"},
     *      description="Delete UserDevice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of UserDevice",
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

        $delete = UserDevice::whereIn('id',$ids)->delete();

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
