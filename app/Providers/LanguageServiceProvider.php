<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $languages = DB::table('languages')->get();

        // $config = [];

        // foreach ($languages as $language) {
        //     $config[$language->code] = [
        //         'display' => $language->name,
        //         'flag-icon' => $language->icon,
        //     ];
        // }

        // config(['languages' => $config]);
    }
}
