<?php

namespace App\Infrastructure\Http\AbstractControllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Server(url="/api")
 * @OA\Info(
 *   title="Hydrogen Laravel Generator APIs",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="amrmohamed257@gmail.com"
 *   )
 * )
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 * ),
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}
