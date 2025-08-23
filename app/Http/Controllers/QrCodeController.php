<?php

namespace App\Http\Controllers;

use App\Models\Client; 
use App\Models\QRcode;
use Illuminate\Http\Request;

use App\Http\Controllers\Bases\RessourceController;
class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrcodes = QRcode::all();
        return view('dashboard.pages.qrcodes.index', compact('qrcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.qrcodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|string',
            'content' => 'required|string',
            'type' => 'nullable|string',
        ]);
        $fields = [
            'content',
            'type'
        ];

        $qrcode = new QRcode;
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $qrcode->$field = $request->$field;
            }
        }
        $fields = [
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $qrcode->$field = json_encode($request->$field);
            }
        }
        if ($request->hasfile('image')) {
            $path = '/assets/images/qrcodes/';
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $path, 500, 500);
            $qrcode->image = $filename;
        }
        $qrcode->user_id = $request->user()->id;
        $qrcode->save();
        return redirect()->route('qrcodes.edit', $qrcode->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $qrcode = QRcode::findOrFail($id); 
        $result = $qrcode->generate();
        return view('dashboard.pages.qrcodes.view', compact('qrcode', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $qrcode = QRcode::findOrFail($id);
        $clients = Client::all()->where('etat', true);
        return view('dashboard.pages.qrcodes.edit', compact('qrcode', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'content' => 'required|string',
            'type' => 'nullable|string', 
            'image' => 'nullable|string', 
        ]);
        $fields = [
            'content',
            'type'
        ];

    try {
        $qrcode = QRcode::where('id', $id)->first();
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $qrcode->$field = $request->$field;
            }
        }

        $fields = [
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $qrcode->$field = json_encode($request->$field);
            }
        }

        if ($request->hasfile('image')) {
            $path = '/assets/images/qrcodes/';
            $ressource_controller = app()->make(RessourceController::class);
            $filename = $ressource_controller->store($request->file('image'), $path, 500, 500);
            $qrcode->image = $filename;
        }

        $qrcode->user_id = $request->user()->id;
        $qrcode->update();
        return back()->with('success', "Modification effectué avec succès.");
        } catch (\Exception $e) { 
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' =>  $e->getMessage()]);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $qrcode = QRcode::findOrFail($id);
        $qrcode->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function pdf($id)
    {
        $qrcode = QRcode::findOrFail($id);
        // $pdf = Pdf::loadView('dashboard.pages.qrcodes.pdf', compact('qrcode'));
        // return $pdf->download($qrcode->numero . '.pdf');
    }

    public function archive($id)
    {
        $qrcode = QRcode::findOrFail($id);
        if ($qrcode->archive == true) {
            $qrcode->archive = false;
            $alert = 'success';
            $message = 'Désarchivivage effectué avec succès.';
        } else {
            $qrcode->archive = true;
            $alert = 'warning';
            $message = 'Archivivage effectué avec succès.';
        }
        $qrcode->update();
        return back()->with($alert, $message);
    }
    public function etat($id)
    {
        $qrcode = QRcode::findOrFail($id);
        if ($qrcode->etat == true) {
            $qrcode->etat = false;
            $alert = 'warning';
            $message = 'Désactivé.';
        } else {
            $qrcode->etat = true;
            $alert = 'success';
            $message = 'Activé.';
        }
        $qrcode->update();
        return back()->with($alert, $message);
    }

    public function statut($id)
    {
        $qrcode = QRcode::findOrFail($id);
        if ($qrcode->statut == true) {
            $qrcode->statut = false;
            $alert = 'warning';
            $message = 'Payement annuler.';
        } else {
            $qrcode->statut = true;
            $alert = 'success';
            $message = 'Pyement effectuer avec success.';
        }
        $qrcode->update();
        return back()->with($alert, $message);
    }
    public function download($id)
    {
        $qrcode = QRcode::findOrFail($id);
        $ressource_controller = app()->make(RessourceController::class); 
//         return response()->streamDownload(function () {
//     echo Browsershot::url(route('qrcodes.show', $qrcode->id ))->pdf();
// }, 'page.pdf');

    }
}
