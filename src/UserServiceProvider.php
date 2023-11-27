<?php


namespace Gtd\Extension\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use ReflectionClass;
use Illuminate\Support\Str;
use Gtd\Extension\User\Providers\AuthServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router,\App\Http\Kernel $kernel)
    {
        $extensions = app('suda_extension')->installedExtensions();
        if(isset($extensions['user']))
        {
            $this->loadViewsFrom($extensions['user']['path'].'/resources/views', 'view_extension_user');    
        }

        $this->loadTranslationsFrom(realpath(__DIR__.'/../lang'), 'ext_user_lang');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
    }
    
}
