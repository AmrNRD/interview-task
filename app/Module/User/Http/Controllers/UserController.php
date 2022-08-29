<?php

namespace App\Module\User\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use App\Module\User\Http\Requests\User\UserStoreFormRequest;
use App\Module\User\Http\Requests\User\UserUpdateFormRequest;
use Illuminate\Http\Request;
use App\Infrastructure\Traits\Responder;
use App\Module\User\Entities\User;
use App\Module\User\Http\Resources\User\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;




/**
 * Class UserController
 */
class UserController extends Controller
{
    use Responder;

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'User';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'User';

    /**
     * Module Alias.
     *
     * @var string
     */
    protected $moduleAlias = 'Users';

    public function __construct(){
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      summary="getUserList",
     *      tags={"User"},
     *      description="Get all User",
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
     *                  property="users",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/User")
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

        $index = QueryBuilder::for(User::class)
                    ->allowedFilters(User::getFilters())
					->allowedIncludes(User::$includes);
		    if($request->has('page')){
		        $index=$index->paginate();
		    }else{
		    	$index=$index->get();
		    }
        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.User'),"alias"=>$this->moduleAlias,
            "users"=>UserResource::Collection($index)
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

        $prams=[
            "data"=>["title"=> __('main.add') . ' ' . __('main.User'),"alias"=>$this->moduleAlias,
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      summary="createUser",
     *      tags={"User"},
     *      description="Create User",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/User")
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
     *                  property="user",
     *                  ref="#/components/schemas/User"
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
     * @param  UserStoreFormRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreFormRequest $request){
        $store = User::create($request->validated());

        if($store){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.User'),"alias"=>$this->moduleAlias,
            "user"=>new UserResource($store)
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
     *      path="/users/{id}",
     *      summary="getUserItem",
     *      tags={"User"},
     *      description="Get User",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of User",
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
     *                  property="user",
     *                  ref="#/components/schemas/User"
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
     * @param  User   $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(User $user){
        $prams=[
            "data"=>[
            "title"=>  __('main.show') . ' ' .  __('main.User') . ' : ' . $user->id,
            "alias"=>$this->moduleAlias,"user"=>new UserResource($user)
            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.show"
        ];

        return $this->response($prams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User   $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function edit(User  $user){


        $prams=[
            "data"=>[
            "title"=> __('main.edit') . ' ' . __('main.User'),"alias"=>$this->moduleAlias,
            "user"=>new UserResource($user),

            ],
            "view"=>"{$this->moduleAlias}::{$this->viewPath}.create"
        ];
        return $this->response($prams);
    }

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      summary="updateUser",
     *      tags={"User"},
     *      description="Update User",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of User",
     *           @OA\Schema(
     *             type="{{ID_TYPE}}"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/User")
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
     *                  property="user",
     *                  ref="#/components/schemas/User"
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
     * @param  UserUpdateFormRequest  $request
     * @param  User   $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateFormRequest $request,User $user){
        $update = $user->update($request->validated());

        if($update){

        $prams=[
            "data"=>[
            "title"=> __('main.show-all') . ' ' . __('main.User'),"alias"=>$this->moduleAlias,
            "user"=>new UserResource($user)
            ],
            "redirectTo"=>["route"=>"{$this->resourceRoute}.show","args"=>[$user->id]]
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
     *      path="/users/{id}",
     *      summary="deleteUser",
     *      tags={"User"},
     *      description="Delete User",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of User",
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

        $delete = User::whereIn('id',$ids)->delete();

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
