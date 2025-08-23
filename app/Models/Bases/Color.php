<?php

namespace App\Models\Bases;


class Color
{
    public const PRIMARY = 'primary';
    public const SECONDARY = 'secondary';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DANGER = 'danger';
    public const INFO = 'info';
    public const LIGHT = 'light';
    public const DARK = 'dark';

    private string $value;
    private string $name;
    private string $contrast;

    private static array $data = [];

    // Tableau des attributs
    private static array $attributes = [
        self::PRIMARY => [
            'name' => 'Principal',
            'contrast' => 'light',
        ],
        self::SECONDARY => [
            'name' => 'Secondaire',
            'contrast' => 'dark',
        ],
        self::SUCCESS => [
            'name' => 'Succès',
            'contrast' => 'dark',
        ],
        self::WARNING => [
            'name' => 'Avertissement',
            'contrast' => 'dark',
        ],
        self::DANGER => [
            'name' => 'Danger',
            'contrast' => 'light',
        ],
        self::INFO => [
            'name' => 'Information',
            'contrast' => 'dark',
        ],
        self::LIGHT => [
            'name' => 'Clair',
            'contrast' => 'dark',
        ],
        self::DARK => [
            'name' => 'Sombre',
            'contrast' => 'light',
        ],
    ];

    public function __construct(string $value = 'secondary')
    {
        $this->value = $value;
        $this->name = self::$attributes[$value]['name'] ?? 'Inconnu';
        $this->contrast = self::$attributes[$value]['contrast'] ?? false;
    }

    public function __get(string $property)
    {
        return $this->$property ?? null;
    }

    public static function initialize(): void
    {
        foreach (self::$attributes as $key => $attr) {
            self::$data[$key] = new self($key);
        }
    }

    public static function all(): array
    {
        return self::$data;
    }

    public static function get(?string $value): ?self
    {
        return self::$data[$value] ?? self::$data[self::SECONDARY];
    }

    public static function random(): self
    {
        $values = self::all();
        return self::get($values[array_rand($values)]);
    }

    public static function inverse(self $color): self
    {
        return match ($color->value) {
            self::LIGHT => self::get(self::DARK),
            self::DARK => self::get(self::LIGHT),
            default => self::get(self::SECONDARY),
        };
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return [$r, $g, $b];
    }
}
