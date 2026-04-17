<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\ServiceProvider;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        Paginator::useTailwind();
        
        try {
            $setting = WebsiteSetting::first();
            View::share('setting', $setting);

            View::composer('*', function ($view) {
                $menu = Menu::where('slug','home')
                    ->with(['items' => function($q){
                        $q->whereNull('parent_id')
                          ->orderBy('sort_order')
                          ->with(['children' => function($c){
                              $c->orderBy('sort_order');
                          }]);
                    }])
                    ->first();

                $view->with('dynamicMenu', $menu);
            });
        } catch (\Exception $e) {
            // Ignore if tables don't exist yet during tests or migrations
        }
    }
}
