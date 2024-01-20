<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\AuthApiController as AuthService;
use App\Http\Controllers\EmailController as EmailService;
use App\Http\Requests\Auth\SignupApiRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class SignupApiController extends ApiController
{
    protected $authService;
    protected $emailService;
    protected $userRepository;

    public function __construct(
        AuthService $authService,
        EmailService $emailService,
        UserRepositoryInterface $userRepository
    ) {
        // $this->middleware('JWT', ['except' => ['signup','verify_email']]);
        $this->authService = $authService;
        $this->emailService = $emailService;
        $this->userRepository = $userRepository;
    }

    public function signup(SignupApiRequest $request)
    {
        // return $request;
        // Get the values from the form
        $request = @$request->only(['name', 'email', 'district_code', 'position_id', 'password']);

        /**
         * Check if user exists
         */
        $exists = $this->userRepository->getUserByEmail($request['email']);
        if (@$exists) {
            return $this->errorResponse('EMAIL_EXISTS');
        }

        /**
         * Create the user
         */
        $request['dcode'] = $request['district_code'];
        unset($request['district_code']);
        if ($this->userRepository->create($request)) {
            return $this->successMessage('User successfully created');
        }
        return $this->errorResponse();
    }
}
