<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller {

    public function switchLang($lang){
        $languages = Language::Lists('id','code');
        //dd($languages);
        // if (array_key_exists($lang, $languages)) {
        //     Session::set('applocale', $lang);
        //     Session::set('applangId', $languages[$lang]);
        // }
        Session::set('applocale', $lang);
        Session::set('applangId', $lang);
        return Redirect::back();
    }
}
