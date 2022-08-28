<?php

namespace App\Infrastructure\AbstractProviders;

use App\Common\Helpers\NamespaceCreator;
use App\Common\Helpers\Path;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factory;

abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var string Alias for load Translations and views
     */
    protected $alias;

    /**
     * @var array List of custom Artisan commands
     */
    protected $commands = [];

    /**
     * @var array List of model factories to load
     */
    protected $factories = [];

    /**
     * @var array List of providers to load
     */
    protected $providers = [];

    /**
     * @var array List of policies to load
     */
    protected $policies = [];

    /**
     * @var array List of policies to load
     */
    protected $observers = [];

    /**
     * Boot required registering of views and translations.
     *
     * @throws \ReflectionException
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerComponentViews();
        $this->registerObservers();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
      foreach ($this->policies as $key => $value) {
       Gate::policy($key, $value);
      }
    }

    /**
     * Register domain custom Artisan commands.
     */
    protected function registerCommands()
    {
      $this->commands($this->commands);
    }



    /**
     * Register domain migrations.
     *
     * @throws \ReflectionException
     */
    protected function registerMigrations()
    {
       $this->loadMigrationsFrom($this->modulePath('Database/Migrations'));
    }

    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     *
     * @param string $append
     * @return string
     * @throws \ReflectionException
     */
    protected function modulePath($append = null)
    {
        $reflection = new \ReflectionClass($this);

        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }

    /**
     * Register domain translations.
     *
     * @throws \ReflectionException
     */
    protected function registerTranslations()
    {
       $this->loadTranslationsFrom($this->modulePath('Resources/Lang'), $this->alias);
    }

    /**
     * Register domain Views.
     * Use Views by $alias
     * @throws \ReflectionException
     */
    protected function registerViews()
    {
       $this->loadViewsFrom($this->modulePath('Resources/Views'), $this->alias);
    }

    /**
     * Register domain Views.
     * Use Views by $alias
     * @throws \ReflectionException
     */
    protected function registerObservers()
    {
            foreach($this->observers as $model=>$observer){
                $model::observe($observer);
            }
            $this->loadViewsFrom($this->modulePath('Resources/Views'), $this->alias);
    }

    /**
     * Register Component Views.
     */
    public function registerComponentViews()
    {
        $directory = Path::toCommon('Components');
        if(File::isDirectory($directory)){
            $directories = Path::directories('app','Common','Components');
            foreach($directories as $dir){
                $class = NamespaceCreator::Segments('App','Common','Components',$dir,'Component');
                Blade::component(Str::lower($dir), $class);
            }
            $this->loadViewsFrom(Path::toCommon('Components'),'Component');
        }

    }

    /**
     * Register Module ServiceProviders.
     */
    public function register()
    {
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }

}
