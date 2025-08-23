<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

use App\Models\Bases\Ressource;

class ServiceController extends Controller
{
    public $path = '/assets/images/services/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('dashboard.pages.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'designation' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        $service = new Service;

        $fields = [
            'designation',
            'type',
            // 'email',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $service->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'adresse',
            'site_web',
            'reseaux_sociaux',
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $service->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $service->image = $ressource->uploadImage($this->path, width: 500);
        }

        $service->user_id = $request->user()->id;
        $service->save();
        return redirect()->route('services.edit', $service->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('dashboard.pages.services.view', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('dashboard.pages.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'designation' => 'required|string|max:255',
            'type' => 'required|string',
            // 'email' => 'nullable|email|max:255',
        ]);
        $service = Service::findOrFail($id);

        $fields = [
            'designation',
            'type',
            // 'email',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $service->$field = $request->$field;
            }
        }
        $fields = [
            'telephones',
            'adresse',
            'site_web',
            'reseaux_sociaux',
            'tags',
            'parametre'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $service->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $ressource = Ressource::file($request->file('image'));
            $ressource->setFilename($service->designation);
            $service->image = $ressource->updateImage($this->path . $service->image, $this->path, 500);
        }

        $service->user_id = $request->user()->id;
        $service->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $ressource = Ressource::file($this->path . $service->image);
        $service->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    // public function archive($id)
    // {
    //     $service = Service::findOrFail($id);
    //     if ($service->archive == true) {
    //         $service->archive = false;
    //         $alert = 'success';
    //         $message = 'Désarchivivage effectué avec succès.';
    //     } else {
    //         $service->archive = true;
    //         $alert = 'warning';
    //         $message = 'Archivivage effectué avec succès.';
    //     }
    //     $service->save();
    //     return back()->with($alert, $message);
    // } 
}
