<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use App\Models\Bases\Devise;
use App\Models\Admin\Setting;
// use Illuminate\Support\Facades\Auth;

// $date = '2023-12-01 10:30:00';
// $carbonDate = Carbon::parse($date);
// echo $carbonDate->diffForHumans();

if (!function_exists('formatDate')) {
    function formatDate($date)
    { 
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        return Carbon::parse($time)->format('H:i');
    }
}
if (!function_exists('formatDateTime')) {
    function formatDateTime($datetime)
    {
        return Carbon::parse($datetime)->format('d/m/Y à H:i');
    }
}
if (!function_exists('formatDateHuman')) {
    function formatDateHuman($date)
    { 
        return Carbon::parse($date)->diffForHumans();
    }
}
if (!function_exists('crypter')) {
    function crypter($id)
    {
        try {
            return Crypt::encrypt($id);
        } catch (Exception $e) {
            return back()->with('warning', $e);
        }
    }
}

if (!function_exists('decrypter')) {
    function decrypter($id)
    {
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('warning', $e);
        }
    }
}


if (!function_exists('devise')) { 
    function devise($value = null, $rate = null)
    {
        $devise = new Devise($value);
        if ($rate == null) {
            $rate = $devise->rateUser();
        }
        $devise->convert($rate);
        return $devise;
    }
}

if (!function_exists('settings')) {
    function settings($key = null)
    {
        $settings = Setting::all();
        return $settings->get($key);
    }
}
