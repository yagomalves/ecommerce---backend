<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::with('user')->paginate(10);
    }

    public function store(StoreProfileRequest $request)
    {
        $profile = Profile::create($request->validated());
        return response()->json($profile, 201);
    }

    public function show(Profile $profile)
    {
        return $profile->load('user');
    }

    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->validated());
        return response()->json($profile);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json(null, 204);
    }
}
