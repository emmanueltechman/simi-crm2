<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class LanguageController.
 */
class LanguageController extends Controller
{
    /**
     * @param $lang
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($lang)
    {

        session()->put('locale', $lang);
        $use = Auth::user();
       $use->lang=$lang;
       $use->save();

        return redirect()->back();
    }

    public function direction($dir)

    {

        session()->put('theme', $dir);

        return redirect()->back();
    }
}
