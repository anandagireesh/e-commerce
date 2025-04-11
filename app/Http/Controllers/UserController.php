<?php

namespace App\Http\Controllers;

use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }
    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('address');
        return $this->apiResponseService->success('User profile', $user);
    }
}
