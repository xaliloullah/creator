<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasStatut;
use App\Models\Traits\Jsonify;
use App\Models\Traits\HasImage;
use App\Models\Bases\Color;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QR; 
class QRcode extends Model
{
    use HasUuids, Jsonify, HasStatut, HasImage;
    protected $table = 'qrcodes';


    public function generate() { 
        $size = $this->parametre['size'] ?? 100;
        $style = $this->parametre['style'] ?? 'square';
        $eye = $this->parametre['eye'] ?? 'square';
        $ecl = $this->parametre['error_correction_level'] ?? 'H';
        $gradient = $this->parametre['gradient'] ?? 'vertical';
        [$red, $green, $blue] = Color::hexToRgb($this->parametre['primary'] ?? '#000000');
        if ($this->parametre['secondary'] ?? '') {
            [$gRed, $gGreen, $gBlue] = Color::hexToRgb($this->parametre['secondary'] ?? '#ffffff');
        }
        else{
            [$gRed, $gGreen, $gBlue] = [$red, $green, $blue];
        }
        [$bgRed, $bgGreen, $bgBlue] = Color::hexToRgb($this->parametre['background'] ?? '#000000');

        // [$eyeRed, $eyeGreen, $eyeBlue] = Color::hexToRgb($this->parametre['eye-color'] ?? '#000000');
        // [$bgEyeRed, $bgEyeGreen, $bgEyeBlue] = Color::hexToRgb($this->parametre['background-eye-color'] ?? '#000000');

        $margin = $this->parametre['margin'] ?? '3';
        $logo = public_path('assets/images/'.$this->logo); 


        return QR::size($size) 
             ->format('svg')
             // ->format('png')
            ->encoding('UTF-8')
            ->color($red, $green, $blue)
            ->backgroundColor($bgRed, $bgGreen, $bgBlue)
            ->margin($margin)
            ->errorCorrection($ecl)
            ->style($style)
            ->eye($eye)
            ->gradient($red, $green, $blue, $gRed, $gGreen, $gBlue, $gradient)
            // ->merge($logo, .3, $absolute=true)  
            // ->eyeColor(0, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            // ->eyeColor(1, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            // ->eyeColor(2, $bgEyeRed, $bgEyeGreen, $bgEyeBlue, $eyeRed, $eyeGreen, $eyeBlue)
            ->generate($this->content);
    }
}
