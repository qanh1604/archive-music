<?php

namespace Plugin\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class ModulesServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //add modules
        $pathModule = base_path("Modules");
        if(file_exists($pathModule)) {
            $listModule = array_map('basename', File::directories($pathModule));
            foreach ($listModule as $module) {
                if (is_dir($pathModule . '/' . $module . '/Views')) {
                    $this->loadViewsFrom($pathModule . '/' . $module . '/Views', $module);
                }
                if (is_dir($pathModule . '/' . $module . '/lang')) {
                    $this->loadTranslationsFrom($pathModule . '/' . $module . '/lang', $module);
                }
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
