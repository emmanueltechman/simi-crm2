<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome(Request $request)
    {
      //  $directory = storage_path().'/framework/sessions';
     //   $ignoreFiles = ['.gitignore', '.', '..'];
    //    $files = scandir($directory);
      //  foreach ($files as $file) {
    //        if(!in_array($file,$ignoreFiles)) unlink($directory . '/' . $file);
     //   }
       
        $version= Config::get('version');
        return view('vendor.installer.welcome',compact('version'));
    }
}
