<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\QRcode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QR;
use App\Http\Controllers\Bases\RessourceController;
class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrcodes = QRcode::all();
        return view('dashboard.modules.qrcodes.index', compact('qrcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.modules.qrcodes.create');
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
            $path = '/app/public/images/QRcodes/';
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
        $qrcode = QRcode::findOrFail(decrypter($id));

        $content = $qrcode->content;
        $parametre = json_decode($qrcode->parametre, true);
        $size = $parametre['size'];
        $style = $parametre['style'] ?? 'square';
        $eye = $parametre['eye'] ?? 'square';
        $ecl = $parametre['error_correction_level'] ?? 'H';
        $gradient = $parametre['gradient'] ?? 'vertical';
        [$red, $green, $blue] = $this->hexToRgb($parametre['color'] ?? '#000000');
        [$bgRed, $bgGreen, $bgBlue] = $this->hexToRgb($parametre['background'] ?? '#000000');
        if ($parametre['gradient-color'] ?? '') {
            [$gRed, $gGreen, $gBlue] = $this->hexToRgb($parametre['gradient-color'] ?? '#ffffff');
        }
        else{
            [$gRed, $gGreen, $gBlue] = [$red, $green, $blue];
        }

        [$eyeRed, $eyeGreen, $eyeBlue] = $this->hexToRgb($parametre['eye-color'] ?? '#000000');
        [$bgEyeRed, $bgEyeGreen, $bgEyeBlue] = $this->hexToRgb($parametre['background-eye-color'] ?? '#000000');

        $margin = $parametre['margin'] ?? '3';
        $logo = '/public/assets/images/logo.png';

        $qrCode = QR::size($size)
            ->encoding('UTF-8')
            ->color($red, $green, $blue)
            ->backgroundColor($bgRed, $bgGreen, $bgBlue)
            ->margin($margin)
            ->errorCorrection($ecl)
            ->style($style)
            ->eye($eye)
            // ->eyeColor(0, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            // ->eyeColor(1, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            // ->eyeColor(2, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            ->gradient($red, $green, $blue, $gRed, $gGreen, $gBlue, $gradient)
            ->merge($logo, .3)
            // public_path('assets/images/qr.png')
            ->generate($content);
        // $qrCode;
        // return response($qrCode)
        //     ->header('Content-Type', 'image/svg+xml');
        return view('dashboard.modules.qrcodes.view', compact('qrcode', 'qrCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $qrcode = QRcode::findOrFail($id);
        $clients = Client::all()->where('etat', true);
        return view('dashboard.modules.qrcodes.edit', compact('qrcode', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'content' => 'required|string',
            'type' => 'nullable|string',
            'size' => 'nullable|integer|min:100|max:1000',
            'foreground_color' => 'nullable|string',
            'background_color' => 'nullable|string',
            'image' => 'nullable|string',
            'error_correction_level' => 'nullable|integer|between:1,3',
            'margin' => 'nullable|integer|min:0|max:10',
            'shape' => 'nullable|string',
        ]);
        $fields = [
            'content',
            'type'
        ];


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
        $pdf = Pdf::loadView('dashboard.modules.qrcodes.pdf', compact('qrcode'));
        return $pdf->download($qrcode->numero . '.pdf');
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
        return response($qrcode->contact)
            ->header('Content-Type', 'text/QRcode')
            ->header('Content-Disposition', 'attachment; filename="' . $qrcode->nom . '.vcf"');
    }
    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) == 6) {
            $rgb = sscanf($hex, "%02x%02x%02x");
            return $rgb;
        }

        return null; // Cas où la couleur hex n'est pas valide
    }
}
