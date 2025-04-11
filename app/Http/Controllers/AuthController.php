<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ApiResponseService;
use App\Services\ImageHandleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $imageHandleService;
    protected $apiResponseService;
    public function __construct(ImageHandleService $imageHandleService, ApiResponseService $apiResponseService)
    {
        $this->imageHandleService = $imageHandleService;
        $this->apiResponseService = $apiResponseService;
    }

    public function register(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $userData = $request->only(['first_name', 'last_name', 'email', 'password', 'phone']);
            $userData['password'] = Hash::make($request->password);
            $user = User::create($userData);
            $user->address()->create($request->only(['address_line_1', 'address_line_2', 'city', 'state_id', 'country_id', 'zip_code']));
            if ($request->hasFile('profile_pic')) {
                $user->profile_pic = $this->imageHandleService->uploadImage($request->file('profile_pic'), 'users');
            }
            $user->save();
            DB::commit();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['token'] = $token;
            return $this->apiResponseService->success('User created successfully', $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponseService->error('Failed to create user', 500, $e->getMessage());
        }
    }
}
