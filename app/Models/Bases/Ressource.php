<?php

namespace App\Models\Bases;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class Ressource
{
    protected $path;
    public $data;
    // private $format = 'json';


    public function __construct(mixed $data = null)
    {
        $this->load();
        $this->data = collect($this->data);
    }

    public function load()
    {
        if (Storage::disk('local')->exists($this->path)) {
            $this->data = json_decode(Storage::disk('local')->get($this->path), true);
        } else {
            $this->data = [];
        }
    }

    public function save()
    {
        Storage::disk('local')->put($this->path, json_encode($this->data));
    }


    public static function all(): Collection
    {
        $ressource = new static();
        return collect($ressource->data);
    }

    public static function file($file = null)
    {
        return new Media($file);
    }

    // public function set($key, $value = null)
    // {
    //     $this->data[$key] = $value;
    // }
}

class Media
{
    protected string $name;
    public $file;
    private string $disk = 'public';

    public function __construct($file = null)
    {
        $this->file = $file;
    }

    public function setFilename(string $name): void
    {
        $this->name = $name;
    }

    public function uploadImage(string $path, int $width = 200, ?int $height = null): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->file->getRealPath());
        $image->cover(width: $width, height: $height ?? $width);

        $destination = $this->getPath($path);
        $filename = $this->generateFilename('img');
        $image->save("$destination/$filename");
        return $filename;
    }

    public function updateImage(string $old, string $path, int $width = 200, ?int $height = null): string
    {
        $this->delete($old);
        return $this->uploadImage($path, $width, $height);
    }

    public function uploadFile(string $path, string $type = 'file'): string
    {
        $destination = $this->getPath($path);
        $filename = $this->generateFilename($type);
        $this->file->move($destination, $filename);
        return $filename;
    }

    public function updateFile(string $old, string $path): string
    {
        $this->delete($old);
        return $this->uploadFile($path);
    }

    private function getPath(string $path): string
    {
        $basePath = match ($this->disk) {
            'public' => public_path($path),
            'resource' => resource_path($path),
            'storage' => storage_path($path),
            default => $path,
        };

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true, true);
        }

        return $basePath;
    }

    private function generateFilename(string $prefix): string
    {
        return ($this->name ?? "creator-{$prefix}-" . uniqid()) . '.' . $this->file->getClientOriginalExtension();
    }

    public function delete($path = null): bool
    {
        $path = $this->getPath($path ?? $this->file);
        return File::exists($path) && is_file($path) ? unlink($path) : false;
    }

    public function generateQrCode($size = 100, $color = '#000', $background = '#fff', $text = 'qrcode')
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
