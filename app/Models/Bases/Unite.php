<?php

namespace App\Models\Bases;

use Illuminate\Support\Facades\Auth;
use App\Models\Bases\Ressource;

class Unite extends Ressource
{
    protected $path = 'unite.json';
    protected $disk = 'storage';
    protected Unit $base;
    public Unit $unit;
    public $data;
    public ?float $value;
    public $rates; // Facteurs de conversion

    public function __construct($value = null, $unit = null)
    {
        parent::__construct();
        $this->value = $value;
        $this->setBase(settings('unite', 'm')); // Par défaut : mètre
        $this->setCurrent($unit ?? $this->base->code);
        $this->rates = $this->data['rates'] ?? $this->defaultRates();
    }

    public function convert(?string $to = null)
    {
        $from = $this->unit->code;
        $to = $to ?? $this->base->code;

        if (!isset($this->rates[$from]) || !isset($this->rates[$to])) {
            return $this;
        }

        $this->value = round(($this->value / $this->rates[$from]) * $this->rates[$to], 4);
        $this->setCurrent($to);
        return $this;
    }

    public function base()
    {
        $this->value = $this->value * ($this->rates[$this->base->code] / $this->rates[$this->getCurrent()->code]);
        $this->setCurrent($this->base->code);
        return $this;
    }

    function format($decimals = 2, $separator = ',', $thousand = ' ')
    {
        return number_format($this->value, $decimals, $separator, $thousand);
    }

    public function getBase()
    {
        return $this->base;
    }

    public function setBase($unit)
    {
        $this->base = $this->makeUnit($unit);
    }

    public function getCurrent()
    {
        return $this->unit;
    }

    public function setCurrent($unit)
    {
        $this->unit = $this->makeUnit($unit);
    }

    public function makeUnit($unit)
    {
        return new Unit($unit);
    }

    public function unitUser()
    {
        return Auth::user()->parametre['unite'] ?? session('unite', $this->base);
    }

    public function is_valid($unit)
    {
        return array_key_exists($unit, $this->rates);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    private function defaultRates()
    {
        return [
            // Longueur (mètre)
            'm' => 1,
            'cm' => 100,
            'mm' => 1000,
            'km' => 0.001,
            'in' => 39.3701,
            'ft' => 3.28084,
            'yd' => 1.09361,
            'mi' => 0.000621371,

            // Poids (kilogramme)
            'kg' => 1,
            'g' => 1000,
            'mg' => 1000000,
            'lb' => 2.20462,
            'oz' => 35.274,

            // Volume (litre)
            'L' => 1,
            'mL' => 1000,
            'gal' => 0.264172,
            'qt' => 1.05669,
            'pt' => 2.11338,
            'cup' => 4.22675
        ];
    }
}


class Unit
{
    public string $symbol;
    public string $code;

    public $symbols = [
        'm' => 'm',
        'cm' => 'cm',
        'mm' => 'mm',
        'km' => 'km',
        'in' => '"',
        'ft' => 'ft',
        'yd' => 'yd',
        'mi' => 'mi',
        'kg' => 'kg',
        'g' => 'g',
        'mg' => 'mg',
        'lb' => 'lb',
        'oz' => 'oz',
        'L' => 'L',
        'mL' => 'mL',
        'gal' => 'gal',
        'qt' => 'qt',
        'pt' => 'pt',
        'cup' => 'cup'
    ];

    public function __construct($code)
    {
        $this->code = $code;
        $this->symbol = $this->getSymbol();
    }

    public function getSymbol(): string
    {
        return $this->symbols[$this->code] ?? $this->code;
    }

    public function __toString(): string
    {
        return (string) $this->code;
    }
}
