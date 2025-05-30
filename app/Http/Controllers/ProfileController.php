<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Bases\RessourceController;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        return view('dashboard.admin.settings');
    }
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $fields = [
            'nom'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $request->user()->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'adresse',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $request->user()->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $path = '/assets/images/users/';
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $path, 500, 500);
            $request->user()->image = $filename;
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('success', 'profil mis à jour avec succès');
    }

    public function settings(Request $request)
    {

        // if (!Auth::check()) {
        //     cookie()->queue('devise', $request->devise, 60*24*30); // Mettre à jour le cookie
        // }

        $parametre = $request->user()->parametre;
        $fields = [
            'devise',
            'theme',
            'lang',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $parametre[$field] = $request->$field;
            }
        }
        $request->user()->parametre = json_encode($parametre, true);
        $request->user()->update();
        return back();


        // // Ajouter ou modifier des données
        // $currentData['nouvelle_cle'] = $request->parametre; // Remplace ou ajoute une clé

        // // Réencoder le tableau mis à jour et le sauvegarder
        // $user->$field = json_encode($currentData);

        // // Sauvegarder l'utilisateur
        // $user->save();
        // $fields = [
        //     'parametre'
        // ];
        // foreach ($fields as $field) {
        //     if ($request->has($field)) {
        //         $request->user()->$field = json_encode(array_merge(
        //             json_decode($request->user()->$field, true) ?? [],
        //             (array) $request->$field
        //         ));
        //     }
        // }
        // if ($request->hasfile('logo')) {
        //     $path = '/assets/images/logo/';
        //     $ressource_controller = app()->make(RessourceController::class);
        //     $filename = $ressource_controller->store($request->file('logo'), $path, 500, 500);
        //     $entreprise = json_decode($request->user()->entreprise, true);
        //     $entreprise['logo'] = $filename;
        //     $request->user()->entreprise = json_encode($entreprise);
        // }
        // $request->user()->update();
        // return Redirect::route('profile.edit')->with('success', 'Paramètre mis à jour avec succès');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        if (!$validated) {
            return back()->withErrors(['error' => $validated]);
        }

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('info', 'Votre compte a été supprimé avec succès. Nous sommes désolés de vous voir partir.');
    }
}
