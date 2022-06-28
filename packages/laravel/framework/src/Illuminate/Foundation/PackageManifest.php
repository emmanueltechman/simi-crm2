<?php

namespace Illuminate\Foundation;

use Exception;
use Illuminate\Filesystem\Filesystem;

class PackageManifest
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $files;

    /**
     * The base path.
     *
     * @var string
     */
    public $basePath;

    /**
     * The vendor path.
     *
     * @var string
     */
    public $vendorPath;

    /**
     * The manifest path.
     *
     * @var string|null
     */
    public $manifestPath;

    /**
     * The loaded manifest array.
     *
     * @var array
     */
    public $manifest;

    /**
     * Create a new package manifest instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $basePath
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(Filesystem $files, $basePath, $manifestPath)
    {
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $manifestPath;
        $this->vendorPath = $basePath.'/vendor';
    }

    /**
     * Get all of the service provider class names for all packages.
     *
     * @return array
     */
    public function providers()
    {
        return $this->config('providers');
    }

    /**
     * Get all of the aliases for all packages.
     *
     * @return array
     */
    public function aliases()
    {
        return $this->config('aliases');
    }

    /**
     * Get all of the values for all packages for the given configuration name.
     *
     * @param  string  $key
     * @return array
     */
    public function config($key)
    {
        return collect($this->getManifest())->flatMap(function ($configuration) use ($key) {
            return (array) ($configuration[$key] ?? []);
        })->filter()->all();
    }

    /**
     * Get the current package manifest.
     *
     * @return array
     */
    protected function getManifest()
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        if (! is_file($this->manifestPath)) {
            $this->build();
        }

        return $this->manifest = is_file($this->manifestPath) ?
            $this->files->getRequire($this->manifestPath) : [];
    }

    /**
     * Build the manifest and write it to disk.
     *
     * @return void
     */
    public function build()
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode($this->files->get($path), true);

            $packages = $installed['packages'] ?? $installed;
        }

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $this->write(collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['laravel'] ?? []];
        })->each(function ($configuration) use (&$ignore) {
            $ignore = array_merge($ignore, $configuration['dont-discover'] ?? []);
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());
    }

    /**
     * Format the given package name.
     *
     * @param  string  $package
     * @return string
     */
    protected function format($package)
    {
        return str_replace($this->vendorPath.'/', '', $package);
    }

    /**
     * Get all of the package names that should be ignored.
     *
     * @return array
     */
    protected function packagesToIgnore()
    {
        if (! is_file($this->basePath.'/composer.json')) {
            return [];
        }

        return json_decode(file_get_contents(
            $this->basePath.'/composer.json'
        ), true)['extra']['laravel']['dont-discover'] ?? [];
    }

    /**
     * Write the given manifest array to disk.
     *
     * @param  array  $manifest
     * @return void
     *
     * @throws \Exception
     */
    protected function write(array $manifest)
    {

        if (! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }


        $default=array (
  'anhskohbo/no-captcha' =>
  array (
    'providers' =>
    array (
      0 => 'Anhskohbo\\NoCaptcha\\NoCaptchaServiceProvider',
    ),
    'aliases' =>
    array (
      'NoCaptcha' => 'Anhskohbo\\NoCaptcha\\Facades\\NoCaptcha',
    ),
  ),
  'barryvdh/laravel-ide-helper' =>
  array (
    'providers' =>
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'cmgmyr/messenger' =>
  array (
    'providers' =>
    array (
      0 => 'Cmgmyr\\Messenger\\MessengerServiceProvider',
    ),
  ),
  'facade/ignition' =>
  array (
    'providers' =>
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' =>
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fideloper/proxy' =>
  array (
    'providers' =>
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'fruitcake/laravel-cors' =>
  array (
    'providers' =>
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'laravel/passport' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/sail' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/tinker' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravel/ui' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Ui\\UiServiceProvider',
    ),
  ),
  'laravelcollective/html' =>
  array (
    'providers' =>
    array (
      0 => 'Collective\\Html\\HtmlServiceProvider',
    ),
    'aliases' =>
    array (
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
  ),
  'maatwebsite/excel' =>
  array (
    'providers' =>
    array (
      0 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' =>
    array (
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'mavinoo/laravel-batch' =>
  array (
    'providers' =>
    array (
      0 => 'Mavinoo\\Batch\\BatchServiceProvider',
    ),
    'aliases' =>
    array (
      'Batch' => 'Mavinoo\\Batch\\BatchFacade',
    ),
  ),
  'mews/purifier' =>
  array (
    'providers' =>
    array (
      0 => 'Mews\\Purifier\\PurifierServiceProvider',
    ),
    'aliases' =>
    array (
      'Purifier' => 'Mews\\Purifier\\Facades\\Purifier',
    ),
  ),
  'nesbot/carbon' =>
  array (
    'providers' =>
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' =>
  array (
    'providers' =>
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'rajeshdk/laravel-installer' =>
  array (
    'providers' =>
    array (
      0 => 'RachidLaasri\\LaravelInstaller\\Providers\\LaravelInstallerServiceProvider',
    ),
  ),
  'shivella/laravel-bitly' =>
  array (
    'providers' =>
    array (
      0 => 'Shivella\\Bitly\\BitlyServiceProvider',
    ),
    'aliases' =>
    array (
      'Bitly' => 'Shivella\\Bitly\\Facade\\Bitly',
    ),
  ),
  'yajra/laravel-datatables-oracle' =>
  array (
    'providers' =>
    array (
      0 => 'Yajra\\DataTables\\DataTablesServiceProvider',
    ),
    'aliases' =>
    array (
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ),
  ),
);



        $this->files->replace(
            $this->manifestPath, '<?php return '.var_export(array_merge($default,$manifest), true).';'
        );
    }
}
