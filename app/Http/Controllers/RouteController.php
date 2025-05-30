<?php

namespace App\Http\Controllers;

use App\Models\Tarif;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Config;


class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function accueil()
    {
        $tarifs = Tarif::all();
        return view('pages.main', compact('tarifs'));
    }

    public function dashboard()
    {
        return view('dashboard.pages.main');
    }

    public function docs()
    {
        return view('dashboard.pages.docs');
    }

    public function chats()
    {
        return view('dashboard.modules.chats.pages.main');
    }

    public function test()
    {
        return view('dashboard.pages.test');
    }

    public function resto()
    {
        return view('dashboard.pages.test');
    }



    // public function switchDatabase(Request $request)
    // {
    //     $databaseName = $request->input('database_name'); // Nom de la base de données choisie par l'utilisateur

    //     // Modifier la configuration de la connexion MySQL
    //     config(['database.connections.mysql.database' => $databaseName]);

    //     // Purger la connexion pour appliquer la nouvelle configuration
    //     DB::purge('mysql');

    //     // (Optionnel) Reconnecter la base de données pour la nouvelle configuration
    //     DB::reconnect('mysql');

    //     return redirect()->route('dashboard')->with('status', 'Base de données changée avec succès!');
    // }
}
