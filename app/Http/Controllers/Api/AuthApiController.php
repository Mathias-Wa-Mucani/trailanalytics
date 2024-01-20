<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController as EmailService;
use App\Http\Requests\Auth\LoginApiRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordResetConfirmRequest;
use App\Http\Resources\Auth\LoginUserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends ApiController
{
    use ThrottlesLogins;

    protected $maxAttempts = 1;
    protected $decayMinutes = 1;
    public $emailService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'forgot_password', 'confirm_password_reset']]);
        $this->emailService = $emailService;
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Authenticate user 
     */
    public function login(LoginApiRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // if ($token = $this->guard()->attempt($credentials)) {
        //     return $this->respondWithToken($token);
        // }

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        // return response()->json(['error' => 'Unauthorized'], 401);
        return $this->errorResponse('AUTHENTICATION_FAILED');
    }


    function loginUser($user)
    {
        // $credentials = array('email' => $user->email, 'password' => $user);
        $credentials = array('email' => $user->username, 'password' => $user->clear_password);
        // if ($token = JWTAuth::fromUser($user)) {
        //     return $this->respondWithToken($token);
        // }

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['success' => true, 'message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = $this->guard()->user();

        // if (!$user->emailVerified()) {
        //     return $this->errorResponse('You need to verify your email address');
        // }

        if (!$user->isActive()) {
            return $this->errorResponse('Your account is pending activation');
        }
        /**
         * Check if user is customer
         */
        $payload = new LoginUserResource($this->guard()->user());
        // return $token;

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'payload' => $payload,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    public function forgot_password(Request $request)
    {
        if (!$request['email']) {
            return $this->errorResponse("REQUEST_MISSING_EMAIL");
        }

        $user = User::whereEmail($request['email'])->first();
        if (!@$user) {
            return $this->errorResponse("EMAIL_NOT_FOUND");
        }

        $this->emailService->sendPasswordResetLink(@$user->email);
        return $this->successMessage();
    }


    public function confirm_password_reset(PasswordResetConfirmRequest $request)
    {
        /**
         * get user from token
         */
        $user = User::whereRaw('md5(email) = "' . @$request['token'] . '"')->first();
        if (!$user) {
            return $this->errorResponse("USER_NOT_FOUND");
        }

        $user->password = @$request['new_password'];
        $user->update();
        return $this->successMessage();
    }
}
