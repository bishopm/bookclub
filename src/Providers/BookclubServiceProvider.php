<?php

namespace Bishopm\Bookclub\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form;
use Bishopm\Bookclub\Repositories\SettingsRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Gate;

class BookclubServiceProvider extends ServiceProvider
{
    private $settings;

    protected $commands = [
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, SettingsRepository $settings)
    {
        $this->settings=$settings;
        Schema::defaultStringLength(255);
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/api.routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bookclub');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        config(['auth.providers.users.model'=>'Bishopm\Bookclub\Models\User']);
        config(['auth.defaults.guard'=>'api']);
        config(['auth.guards.api.driver'=>'jwt']);
        if (Schema::hasTable('settings')) {
            /*$finset=$settings->makearray();
            if (($settings->getkey('site_name'))<>"Invalid") {
                config(['app.name'=>$settings->getkey('site_name')]);
            }*/
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->app->bind('setting', function () {
            return new \Bishopm\Bookclub\Repositories\SettingsRepository(new \Bishopm\Bookclub\Models\Setting());
        });
        AliasLoader::getInstance()->alias("Setting", 'Bishopm\Bookclub\Models\Facades\Setting');
        AliasLoader::getInstance()->alias("Socialite", 'Laravel\Socialite\Facades\Socialite');
        AliasLoader::getInstance()->alias("JWTFactory", 'Tymon\JWTAuth\Facades\JWTFactory');
        AliasLoader::getInstance()->alias("JWTAuth", 'Tymon\JWTAuth\Facades\JWTAuth');
        AliasLoader::getInstance()->alias("Form", 'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML", 'Collective\Html\HtmlFacade');
        $this->app['router']->aliasMiddleware('isverified', 'Bishopm\Bookclub\Middleware\IsVerified');
        $this->app['router']->aliasMiddleware('handlecors', 'Barryvdh\Cors\HandleCors');
        $this->app['router']->aliasMiddleware('jwt.auth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->app['router']->aliasMiddleware('role', 'Spatie\Permission\Middlewares\RoleMiddleware');
        $this->app['router']->aliasMiddleware('permission', 'Spatie\Permission\Middlewares\PermissionMiddleware');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Bishopm\Bookclub\Repositories\AuthorsRepository',
            function () {
                $repository = new \Bishopm\Bookclub\Repositories\AuthorsRepository(new \Bishopm\Bookclub\Models\Author());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Bookclub\Repositories\BooksRepository',
            function () {
                $repository = new \Bishopm\Bookclub\Repositories\BooksRepository(new \Bishopm\Bookclub\Models\Book());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Bookclub\Repositories\LoansRepository',
            function () {
                $repository = new \Bishopm\Bookclub\Repositories\LoansRepository(new \Bishopm\Bookclub\Models\Loan());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Bookclub\Repositories\SettingsRepository',
            function () {
                $repository = new \Bishopm\Bookclub\Repositories\SettingsRepository(new \Bishopm\Bookclub\Models\Setting());
                return $repository;
            }
        );
        $this->app->bind(
            'Bishopm\Bookclub\Repositories\UsersRepository',
            function () {
                $repository = new \Bishopm\Bookclub\Repositories\UsersRepository(new \Bishopm\Bookclub\Models\User());
                return $repository;
            }
        );
    }
}
