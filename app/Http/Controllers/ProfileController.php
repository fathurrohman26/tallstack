<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PasswordChange;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    /**
     * Update info
     *
     * @param ProfileUpdateRequest $request
     * @return mixed
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;

            if ($request->user()->save()) {
                $request->user()->sendEmailVerificationNotification();

                return redirect()->route('home')->with('status', 'profile-updated');
            }

            return redirect()->route('profile')->with('error', 'An unexpected error occurred while updating your profile.');
        }

        if ($request->user()->save()) {
            return redirect()->route('profile')->with([
                'status'  => 'profile-updated',
                'success' => 'Profile information updated successfully.'
            ]);
        }

        return redirect()->route('profile')->with('error', 'An unexpected error occurred while updating your profile.');
    }

    /**
     * Update password
     *
     * @param Request $request
     * @return mixed
     */
    public function password(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $update = $request->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        if ($update) {
            // TODO: Secure account business process

            // testing
            $mail = new PasswordChange($request->user());

            Mail::to($request->user()->email)->send($mail);

            return redirect()->route('profile')->withoutFragment()->with([
                'status'  => 'password-updated',
                'success' => 'Account password updated successfully.'
            ]);
        }

        return redirect()->route('profile')->with('error', 'An unexpected error occurred while updating your profile.');
    }

    /**
     * Delete account
     *
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        if (Hash::check($request->delete_password, $request->user()->password) === false) {
            return back()
                ->with('deleting_account', true)
                ->with('delete_password', 'The password is incorrect.');
        }

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', ['reason' => 'bye']);
    }
}
