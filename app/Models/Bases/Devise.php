<?php

namespace App\Models\Bases;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Bases\Ressource;

class Devise extends Ressource
{
    protected $path = 'devise.json';
    // protected $disk = 'storage';
    protected Rate $base;
    public Rate $rate;
    protected $api_url;
    public $data;
    public ?float $value;
    public $rates;
    public $supported;

    public function __construct($value = null, $rate = null)
    {
        parent::__construct();
        $this->value = $value;
        $this->setBase(settings('devise', 'XOF'));
        $this->setCurrent($rate ?? $this->base->code);
        $this->rates = $this->data['rates'] ?? [];
    }

    public function update()
    {
        $this->api_url = 'https://open.er-api.com/v6/latest/' . $this->base->code;
        $response = Http::get($this->api_url);
        if ($response->successful()) {
            $this->data = $response->json();
            if (isset($this->data['rates'])) {
                $this->rates = $this->data['rates'];
                return $this->save();
            }
        }
        return false;
    }

    public function convert(?string $to = null)
    {
        $from = $this->rate->code;
        $to = $to ?? $this->base->code;

        if (!isset($this->rates[$from]) || !isset($this->rates[$to])) {
            return $this;
        }
        $this->value = round(($this->value / $this->rates[$from]) * $this->rates[$to], 2);
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

    public function setBase($rate)
    {
        $this->base = $this->makeRate($rate);
    }

    public function getCurrent()
    {
        return $this->rate;
    }

    public function setCurrent($rate)
    {
        $this->rate = $this->makeRate($rate);
    }

    public function makeRate($rate)
    {
        return new Rate($rate);
    }

    public function rateUser()
    {
        return  Auth::user()->parametre['devise'] ?? session('devise', $this->base);
    }

    public function is_valid($rate)
    {
        return array_key_exists($rate, $this->rates);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}


class Rate
{
    public string $name;
    public string $symbol;
    public string $code;

    public static array $names = [
        'EUR' => 'Euro',
        'USD' => 'Dollar',
        'GBP' => 'Livre Sterling',
        'JPY' => 'Yen',
        'INR' => 'Roupie Indienne',
        'XOF' => 'Franc CFA',
        'CHF' => 'Franc Suisse',
        'CRC' => 'Colón Costaricain',
        'PYG' => 'Guarani Paraguyen',
        'UAH' => 'Hryvnia Ukrainienne',
        'RUB' => 'Rouble Russe'
    ];

    public static array $symbols = [
        'EUR' => '€',
        'USD' => '$',
        'GBP' => '£',
        'JPY' => '¥',
        'INR' => '₹',
        'XOF' => 'F',
        'CHF' => '₣',
        'CRC' => '₡',
        'PYG' => '₲',
        'UAH' => '₴',
        'RUB' => '₽',
    ];

    public function __construct($code)
    {
        $this->code = $code;
        $this->name = $this->getName();
        $this->symbol = $this->getSymbol();
    }


    public function getSymbol(): string
    {
        return $this->symbols[$this->code] ?? $this->code;
    }

    public function getName(): string
    {
        return $this->names[$this->code] ?? $this->code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return (string) $this->code;
    }

}
