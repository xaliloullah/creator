<?php

namespace App\Http\Controllers;

use App\Models\VCard;
use Illuminate\Http\Request;
use App\Models\Bases\Ressource;

class VCardController extends Controller
{
    public $path = '/assets/images/vcards/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vcards = VCard::where('user_id', $request->user()->id)->get();
        return view('dashboard.pages.vcards.index', compact('vcards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.vcards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string',
        ]);

        $vcard = new VCard;
        $fields = [
            'prenom',
            'nom',
            'email',
            'organisation',
            'titre',
            'description',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $vcard->$field = $request->$field;
            }
        }

        $fields = [
            'telephones',
            'reseaux_sociaux',
            'adresse',
            'site_web',
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $vcard->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $vcard->image = $ressource->uploadImage($this->path, width: 500);
        }
        $vcard->user_id = $request->user()->id;
        $vcard->contact = $this->make_vcard($vcard);
        $vcard->save();
        return redirect()->route('vcards.edit', $vcard->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vcard = VCard::findOrFail($id);
        return view('dashboard.pages.vcards.view', compact('vcard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vcard = VCard::findOrFail($id);
        return view('dashboard.pages.vcards.edit', compact('vcard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'prenom' => 'required|string',
        ]);

        $vcard = VCard::where('id', $id)->first();
        $fields = [
            'prenom',
            'nom',
            'email',
            'organisation',
            'titre',
            'description',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $vcard->$field = $request->$field;
            }
        }

        $fields = [
            'telephones',
            'reseaux_sociaux',
            'adresse',
            'site_web',
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $vcard->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $vcard->image = $ressource->updateImage($this->path . $vcard->image, $this->path, 500);
        }
        // $vcard->user_id = $request->user()->id;
        // $adresse = json_decode($vcard->adresse, true) ?? [];
        // $telephone = json_decode($vcard->telephones, true)[0] ?? '';
        // $site_web = json_decode($vcard->site_web, true)[0] ?? '';
        // $rue = $adresse['rue'] ?? '';
        // $ville = $adresse['ville'] ?? '';
        // $code_postal = $adresse['code_postal'] ?? '';
        // $pays = $adresse['pays'] ?? '';
        // $image = asset('storage/images/vcards/' . $vcard->image) ?? '';

        $vcard->contact = $this->make_vcard($vcard);
        $vcard->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vcard = VCard::findOrFail($id);
        $vcard->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    // public function archive($id)
    // {
    //     $vcard = VCard::findOrFail($id);
    //     if ($vcard->archive == true) {
    //         $vcard->archive = false;
    //         $alert = 'success';
    //         $message = 'Désarchivivage effectué avec succès.';
    //     } else {
    //         $vcard->archive = true;
    //         $alert = 'warning';
    //         $message = 'Archivivage effectué avec succès.';
    //     }
    //     $vcard->update();
    //     return back()->with($alert, $message);
    // }
    // public function etat($id)
    // {
    //     $vcard = VCard::findOrFail($id);
    //     if ($vcard->etat == true) {
    //         $vcard->etat = false;
    //         $alert = 'warning';
    //         $message = 'Désactivé.';
    //     } else {
    //         $vcard->etat = true;
    //         $alert = 'success';
    //         $message = 'Activé.';
    //     }
    //     $vcard->update();
    //     return back()->with($alert, $message);
    // }

    // public function statut($id)
    // {
    //     $vcard = VCard::findOrFail($id);
    //     if ($vcard->statut == true) {
    //         $vcard->statut = false;
    //         $alert = 'warning';
    //         $message = 'Payement annuler.';
    //     } else {
    //         $vcard->statut = true;
    //         $alert = 'success';
    //         $message = 'Pyement effectuer avec success.';
    //     }
    //     $vcard->update();
    //     return back()->with($alert, $message);
    // }
    public function download($id)
    {
        $vcard = VCard::findOrFail($id);
        return response($vcard->contact)
            ->header('Content-Type', 'text/vcard')
            ->header('Content-Disposition', 'attachment; filename="' . $vcard->prenom . ' ' . $vcard->nom . '.vcf"');
    }

    private function make_vcard($vcard)
    {
        $telephones = implode(",", $vcard->telephones);
        $site_web = implode(",", $vcard->site_web);
        $adresse = implode(";", $vcard->adresse);
        // dd($adresse);
        // $image = asset("/assets/images/" . $vcard->image());
        $contact = "BEGIN:VCARD\n";
        $contact .= "VERSION:3.0\n";
        $contact .= "FN:$vcard->prenom\n";
        $contact .= "N:$vcard->nom;;;\n";
        $contact .= "TEL:$telephones\n";
        $contact .= "EMAIL:$vcard->email\n";
        $contact .= "ADR;:;; $adresse\n";
        $contact .= "ORG:$vcard->organisation\n";
        $contact .= "TITLE:$vcard->titre\n";
        $contact .= "URL:$site_web\n";
        // $contact .= "PHOTO;VALUE=URI:$image \n";
        // $contact .= "BDAY:$vcard->birthday\n"; 
        $contact .= "END:VCARD\n";
        return $contact;
    }
} 