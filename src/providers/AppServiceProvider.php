<?php

namespace App\Providers;

use App\Models\ActivityTbl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


      /**
       * Register any other events for your application.
       *
       * @param  \Illuminate\Contracts\Events\Dispatcher  $events
       * @return void
       */
       public function boot()
    {
      ActivityTbl::deleting(function($acts) {
         foreach ($acts->details()->get() as $detail) {
            $detail->delete();
         }
      });
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
