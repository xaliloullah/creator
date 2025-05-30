<?php

namespace App\Http\Controllers;

use App\Models\Journal;

use Illuminate\Http\Request;
use App\Models\Bases\Ressource;

class journalController extends Controller
{
    public $path = '/assets/images/journals/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $journals = Journal::all();
        return view('dashboard.modules.journals.index', compact('journals'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('dashboard.modules.journals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'designation' => "required|string|max:255",
            // 'recettes' => "nullable",
            // 'depenses' => "nullable",
            'tag' => "max:65535",
            'parametre' => "max:65535",
            'description' => "max:65535"
        ]);

        $journal = new Journal;

        $fields = [
            'date',
            'designation',
            'recettes',
            'depenses',
            'description'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $journal->$field = $request->$field;
            }
        }
        $fields = [
            'tags',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $journal->$field = json_encode($request->$field);
            }
        }


        // if ($request->hasfile('image')) {
        //     $ressource = Ressource::file($request->file('image'));
        //     $ressource->setFilename($journal->designation);
        //     $journal->image = $ressource->uploadImage($this->path, width: 500);
        // }

        $journal->user_id = $request->user()->id;
        $journal->save();
        return back()->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $journal = Journal::findOrFail($id);
        return view('dashboard.modules.journals.view', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $journal = Journal::findOrFail($id);
        return view('dashboard.modules.journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            'designation' => "required|string|max:255",
            // 'recettes' => "nullable",
            // 'depenses' => "nullable",
            'tag' => "max:65535",
            'parametre' => "max:65535",
            'description' => "max:65535"
        ]);
        $journal = Journal::findOrFail($id);

        $fields = [
            'date',
            'designation',
            'recettes',
            'depenses',
            'description'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $journal->$field = $request->$field;
            }
        }

        $fields = [
            'tags',
            'parametre'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $journal->$field = json_encode($request->$field);
            }
        }

        // if ($request->hasfile('image')) {
        //     $ressource = Ressource::file($request->file('image'));
        //     $ressource->setFilename($journal->designation);
        //     $journal->image = $ressource->updateImage($this->path . $journal->image, $this->path, 500);
        // }

        $journal->user_id = $request->user()->id;
        $journal->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $ressource = Ressource::file($this->path . $journal->image);
        $journal->delete();
        $ressource->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
