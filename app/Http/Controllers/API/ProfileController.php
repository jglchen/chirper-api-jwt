<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserFollow;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $user = Auth::user();
        return response()->json([
            'message' => 'Profile successfully updated',
            'user' => $user,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        
        $deleteduser = $user->id;

        //Auth::logout();
        //Auth::user()->tokens()->delete();
        $user->delete();

        /*Clean UserFlow models as the filed of followed_id equal $deleteduser*/
        $deleted = UserFollow::where('followed_id', $deleteduser)->delete();
 
        return response()->json([
            'message' => 'Account already deleted.',
        ]);

    }

}
