<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/profile",
     *     tags={"Profile"},
     *     summary="Find all the parameters for the profile update form",
     *     description="Find all the parameters for the profile update form",
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

      /**
     * @OA\Patch(
     *     path="/profile",
     *     tags={"Profile"},
     *     summary="Update profile",
     *     description="Update profile",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", description="Name of profile"),
     *                 @OA\Property(property="email", type="string", description="Email of profile"),
     *                 example={"name": "Juan Perez", "email": "juan.perez@spot2.com"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=303, description="OK"),
     *     @OA\Response(response=302, description="Validation error")
     * )
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

       /**
     * @OA\Delete(
     *     path="/profile",
     *     tags={"Profile"},
     *     summary="Delete user and profile",
     *     description="Delete user and profile",
     *     @OA\Response(response=303, description="OK"),
     *     @OA\Response(response=302, description="Validation error")
     * )
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
