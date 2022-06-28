<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use RachidLaasri\LaravelInstaller\Events\LaravelInstallerFinished;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use RachidLaasri\LaravelInstaller\Helpers\FinalInstallManager;
use RachidLaasri\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \RachidLaasri\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \RachidLaasri\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        // $finalEnvFile = $environment->getEnvContent();
        $ln = $this->sym_link();
        event(new LaravelInstallerFinished);
        return view('vendor.installer.finished', compact('ln'));
    }


    function sym_link($f = '/public')
    {

        if (file_exists(public_path() . '/storage')) {
            @unlink(public_path() . '/storage');
        }

        if (@symlink(storage_path(), public_path() . '/storage')) {
            return 'Symlink created for ' . storage_path() . ' in ' . public_path() . '/storage';
        } else {
            return ' Error in Symlink creation, Linux/Unix users may face issue in file loading. Create a symbolic   for ' . storage_path() . '  in ' . public_path() . '/storage';
        }
    }
}
