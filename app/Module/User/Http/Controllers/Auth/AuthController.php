<?php

namespace App\Module\User\Http\Controllers\Auth;


use App\Module\User\Entities\User;
use App\Module\User\Http\Requests\User\UserAPILoginFormRequest;
use App\Module\User\Http\Requests\User\UserAPIRegisterFormRequest;
use App\Module\User\Http\Requests\User\UserAPISocialLoginFormRequest;
use App\Infrastructure\Traits\Responder;
use App\Module\User\Http\Resources\User\UserResource;
use App\Module\User\Http\Services\RegisterDeviceService;
use App\Module\User\Http\Services\RegisterUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\Register;
use phpDocumentor\Reflection\Types\Nullable;


class AuthController extends Controller
{
    use Responder;


    /**
     * @var RegisterUserService
     */
    protected $registerUserService;

    /**
     * @var RegisterDeviceService
     */
    protected $registerDeviceService;



    /**
     * @param RegisterUserService $registerUserService
     * @param RegisterDeviceService $registerDeviceService
     */
    public function __construct(RegisterUserService $registerUserService, RegisterDeviceService $registerDeviceService)
    {
        $this->registerUserService = $registerUserService;
        $this->registerDeviceService = $registerDeviceService;
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      summary="Login",
     *      tags={"Auth"},
     *      description="Login",
     *      @OA\RequestBody(
     *        required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="firebase_token",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="platform",
     *                  type="string",
     *                  description="either IOS, Android",
     *              ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="access_token",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="expires_at",
     *                  type="string",
     *                  format="date-time"
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
     *      ),
     * @OA\Response(
     *     response=422,
     *     description="Validation error",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="The given data was invalid."),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *        )
     *     )
     *  ),
     * )
     * Login user and create token
     * @param UserAPILoginFormRequest $request
     * @return JsonResponse
     */
    public function login(UserAPILoginFormRequest $request)
    {
        $data = $request->validated();

        $credentials = Arr::only($data, ['email', 'password']);

        if (!auth()->attempt($credentials))
            return response()->json(['message' => 'Invalid email or password.'], 422);

        return $this->initiateLoginToken(auth()->user(), $data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return JsonResponse
     */
    protected function initiateLoginToken(User $user, array $data): JsonResponse
    {
//        $device = $this->checkForDevice($user, Arr::only($data, ['type', 'firebase_token', 'platform']));

        return $this->createToken($user, __('user.Logged in successfully'), 200, null);
    }

    /**
     * @OA\Post(
     *      path="/auth/signup",
     *      summary="Login",
     *      tags={"Auth"},
     *      description="Login",
     *      @OA\RequestBody(
     *        required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="name",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="password_confirmation",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="firebase_token",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="platform",
     *                  type="string",
     *                  description="either IOS, Android",
     *              ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="access_token",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="expires_at",
     *                  type="string",
     *                  format="date-time"
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
     *      ),
     * @OA\Response(
     *     response=422,
     *     description="Validation error",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="The given data was invalid."),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *        )
     *     )
     *  ),
     * )
     * Login user and create token
     * @param UserAPIRegisterFormRequest $request
     * @return JsonResponse
     */
    public function signup(UserAPIRegisterFormRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->initiateSignup($data);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function initiateSignup(array $data): JsonResponse
    {
        $user = $this->registerUserService->register(Arr::except($data, ['type', 'firebase_token', 'platform']));

//        $device = $this->checkForDevice($user, Arr::only($data, ['type', 'firebase_token', 'platform']));

//        $user->sendEmailVerificationNotification();

        return $this->createToken($user, __('user.Signed up successfully'), 201, null);
    }

    /**
     * Login or Sign up user using social login
     * @param UserAPISocialLoginFormRequest $request
     * @return JsonResponse
     */
    public function loginWithProvider(UserAPISocialLoginFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('provider_id' , $data['user_id'])->where( 'provider_name' , $data['provider_type'])->first();
        if ($user) {
            $user = $this->resendEmailVerification($user);
            return $this->initiateLoginToken($user, $data);
        } else {
            return $this->initiateSocialSignup($data);
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function initiateSocialSignup(array $data): JsonResponse
    {
        if ((!Arr::has($data,'email')||$data['email']==null)&&$data['provider_type']=="apple"){
            $data['email']=$data['user_id']."@apple.com";
        }else if(!Arr::has($data,'email')||$data['email']==null){
            return response()->json(['message' => __('user.Email not found')], 422);
        }

        $user = User::findWhere(['email' => $data['email']])->first();
        if ($user)
            return response()->json(['message' => __('user.Email found')], 422);

        return response()->json(['message' => __('Not valid')], 422);
    }

    /**
     * create Token
     *
     * @param User $user
     * @param string $message
     * @param int $status_code
     * @param null $device
     * @return JsonResponse
     */
    public function createToken(User $user, $message = "", $status_code = 200, $device = null): JsonResponse
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonths(3);
        $token->save();
        return response()->json(['status' => 'success', 'message' => $message, 'access_token' => $tokenResult->accessToken, 'user' => new UserResource($user), 'token_type' => 'Bearer', 'device' => $device, 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()], $status_code);
    }

    /**
     * update or create UserDevice
     * @param User $user
     * @param array $data
     * @return UserDevice|null
     */
    public function checkForDevice(User $user, array $data): ?UserDevice
    {
        return $this->registerDeviceService->register($user, $data['firebase_token'], $data['platform']);
    }

    /**
     * @param User $user
     * @return User
     */
    protected function resendEmailVerification(User $user): User
    {
        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }
        return $user;
    }


    /**
     * @return JsonResponse
     */
    protected function profile(): JsonResponse
    {
        return response()->json(['user'=>new UserResource(Auth::user())]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
