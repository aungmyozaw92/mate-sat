<?php

namespace App\Http\Controllers\Web\Api\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\UserService;
use App\Http\Resources\Web\api\v1\User\UserResource;
use App\Http\Requests\Web\Profile\CheckPasswordRequest;
use App\Http\Requests\Web\Profile\UpdateProfileRequest;
use App\Http\Requests\Web\Profile\CheckPhoneNoValidRequest;
use App\Http\Resources\Web\api\v1\Customer\CustomerResource;
use App\Services\Web\api\v1\CustomerService;

class AuthController extends Controller
{
    protected $userService;
    protected $customerService;
    public function __construct(UserService $userService, CustomerService $customerService)
    {
        $this->userService = $userService;
        $this->customerService = $customerService;
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['status'=> 2 ,'message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'status' => 1,
            'message' => 'Success',
            'access_token' => $accessToken,
            'user' => UserResource::make(auth()->user()->load(['roles'])),
        ]);
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => 1,
            'message' => 'Successful logout',
        ], 200);
    }

    public function profile()
    {
        $user = auth()->user();
        return response()->json([
            'status' => 1,
            'data' => [
                'user' => UserResource::make($user->load(['roles']))
            ],
        ], 200);
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user = $request->updateProfile($user);

        return response()->json(['status' => 1, 'message' => 'Successfully updated!'], 200);
    }

    public function check_password(CheckPasswordRequest $request)
    {
        $data = $this->userService->checkPassword($request->only(['password']));
        return $data;
    }

    public function check_phone_no_valid(CheckPhoneNoValidRequest $request)
    {
        $customer = $this->customerService->getCheckCustomer($request['phone_no']);
        if (!$customer) {
            return response()->json([
                'status' => 2,
                'message' => 'Customer does not exit'
            ]);
        }
        return new CustomerResource($customer);
    }
    
}
