<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;

use App\Models\Bases\Statut;
use App\Models\Bases\Module;
use App\Models\Bases\Color;
// use App\Models\Bases\Devise;
// use App\Enums\Color;
use App\Enums\Icon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Statut::initialize();
        Module::initialize();
        Color::initialize();


        View::share('icons', Icon::all());
        View::share('colors', Color::all());

        try {


            foreach (Role::all() as $role) {
                Blade::if($role->name, function () use ($role) {
                    /** @var User $user */
                    $user = Auth::user();
                    return $user && ($user->hasRole($role->name));
                });
            }
        } catch (\Exception $e) {
            // Handle the exception if needed, e.g., log it or display a message;
        }
    }
}
