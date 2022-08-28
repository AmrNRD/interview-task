<?php

namespace App\Infrastructure\Traits;

use App\Infrastructure\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Support\Arr;

trait Responder{


       /**
        * @param array $data
        * @param string|null $view
        * @param \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|null $apiResponse
        * @param int $response_code
        * @param bool $redirectBack
        * @param array|null $redirectTo
        * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
        */
       public function response(array $data) {

           if(request()->expectsJson()){
               if(Arr::has($data,'apiResponse')){
                   return $data['apiResponse'];
               }else{
                   return response()->json($data['data'],Arr::has($data,'response_code')?$data['response_code']:200);
               }

           }else{

               if(Arr::has($data,'redirectBack')&&$data['redirectBack']){
                   return back()->with($data['data']);
               }else if(Arr::has($data,'redirectTo')){
                   return redirect()->route($data['redirectTo']['route'],Arr::has($data['redirectTo'],'args')?$data['redirectTo']['args']:[])->with($data['data']);
               }else{
                   return view($data['view'],$data['data']);
               }
           }
       }
}
