<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::with('user')->paginate(10);
    }
    // 🔥 NOVO MÉTODO: Retorna o perfil do usuário logado
    public function getCurrentUserProfile(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        return response()->json([
            'profile' => $profile
        ]);
    }

    // 🔥 NOVO MÉTODO: Retorna perfil por user_id
    public function getProfileByUserId($userId)
    {
        $profile = Profile::where('user_id', $userId)->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Perfil não encontrado'
            ], 404);
        }

        return response()->json([
            'profile' => $profile
        ]);
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
