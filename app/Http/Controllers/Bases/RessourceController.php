<?php

namespace App\Http\Controllers\Bases;

use App\Http\Controllers\Controller;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Http\Request;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function load($path)
    {
        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->get($path);
        }
    }

    public function save($path, $data)
    {
        Storage::disk('local')->put($path, $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($file, $path, $width = 200, $height = 200)
    {
        $mimeType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        if (str_starts_with($mimeType, 'image/')) {
            $filename = "creator-image-" . uniqid() . ".$extension";
            $destination = $this->unsure_path_exist($path);
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->cover(width: $width, height: $height);
            $image->save("$destination/$filename");
        } elseif (str_starts_with($mimeType, 'video/')) {
            $filename = 'creator-video-' . uniqid() . ".$extension";
            $destination = $this->unsure_path_exist($path);
            $file->move($destination, $filename);
        } else {
            $filename = 'creator-file-' . uniqid() . ".$extension";
            $destination = $this->unsure_path_exist($path);
            $file->move($destination, $filename);
        }

        return $filename;
    }

    public function unsure_path_exist(string $path)
    {
        $destination = public_path($path);
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }
        return $destination;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $path)
    {
        $this->destroy($path);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($old, $file, $path, $width = 200, $height = 200)
    {
        $this->destroy($old);
        return $this->store($file, $path, $width, $height);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($path)
    {
        $path = public_path($path);

        if (File::exists($path) && is_file($path)) {
            unlink($path);
            return back()->with('success', 'Fichier supprimé avec succès.');
        }
        return back()->with('error', 'Fichier introuvable ou invalide.');
    }

    public function qrcode($size = 100, $color = '#000', $background = '#fff', $text = 'qrcode')
    {
        [$red, $green, $blue] = $this->hexToRgb($color);
        [$bgRed, $bgGreen, $bgBlue] = $this->hexToRgb($background);

        $qrcode = QrCode::size($size)
            ->color($red, $green, $blue)
            ->backgroundColor($bgRed, $bgGreen, $bgBlue)
            ->generate($text);
        return $qrcode;
    }

    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $rgb = sscanf($hex, "%02x%02x%02x");
        return $rgb;
    }
}
