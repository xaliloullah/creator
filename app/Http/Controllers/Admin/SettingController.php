<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Admin\Setting;
use App\Models\Bases\Devise;

class SettingController extends Controller
{

    public function update(Request $request)
    {

        $settings = new Setting();
        if ($request->has('devise')) {
            $devise = new Devise();
            $devise->setBase($request->devise);
            $devise->update();
        }
        $fields = [
            'devise',
            'mode',
            'description',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $settings->data[$field] = $request->$field;
            }
        }

        $settings->save();

        return back();
    }
}
