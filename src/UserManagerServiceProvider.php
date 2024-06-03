<?php
/**
 * User Manager Service Provider
 */

namespace Roelvanlierop\Usermanager;

use Illuminate\Support\ServiceProvider;

/**
 * User Manager Service Provider
 *
 * This service provider helps Laravel enable the User Manager module and publish / load the needed hooks into Laravel.
 *
 * @package RoelvanLierop\Usermanager
 * @author Roel van Lierop | Prodiz Memoria Lead Developer - <roel.van.lierop@gmail.com>
 * @category Laravel Service Provider
 */
class UserManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void Register functions in Service providers do not return any data
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void Boot functions in Service providers do not return any data
     * @link ../vendor/roelvanlierop/usermanager/config/app.php
     * @link ../vendor/roelvanlierop/usermanager/config/usermanager.php
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'usermanager');
        $this->loadRoutesFrom( __DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'usermanager');

        $this->publishes([
            __DIR__ . '/../config/usermanager.php' => config_path('usermanager.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/js' => public_path('js'),
        ], 'javascript');

        $this->publishes([
            __DIR__ . '/../resources/views/account.blade.php' => resource_path('views/vendor/usermanager/account.blade.php')
        ], 'views');
    }
}
