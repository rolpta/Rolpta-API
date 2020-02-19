<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_DEPRECATED));

    Schema::defaultStringLength(191);
  }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app()->path() . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }
        //
    }
}
