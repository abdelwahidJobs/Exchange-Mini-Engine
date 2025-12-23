<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get authenticated user profile with balances.
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('assets');

        return new ProfileResource($user);
    }
}
