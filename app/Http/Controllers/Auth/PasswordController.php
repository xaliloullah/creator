<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if (!$validated) {
            return back()->withErrors(['error' => $validated]);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        Auth::logout();

        return redirect()->route('login')->with('info', 'Votre mot de passe a bien été modifié. Vous avez été déconnecté pour des raisons de sécurité.');
    }
}
