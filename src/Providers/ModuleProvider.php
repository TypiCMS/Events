<?php
namespace TypiCMS\Modules\Events\Providers;

use Config;
use Eluceo\iCal\Component\Calendar as EluceoCalendar;
use Eluceo\iCal\Component\Event as EluceoEvent;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\EventTranslation;
use TypiCMS\Modules\Events\Repositories\CacheDecorator;
use TypiCMS\Modules\Events\Repositories\EloquentEvent;
use TypiCMS\Modules\Events\Services\Calendar;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.events'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'events');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'events');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/events'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests'),
        ], 'tests');

        AliasLoader::getInstance()->alias(
            'Events',
            'TypiCMS\Modules\Events\Facades\Facade'
        );

        // Observers
        EventTranslation::observe(new SlugObserver);
        Event::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Events\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Events\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function (Application $app) {
            $repository = new EloquentEvent(new Event);
            if (! config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'events', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Events\Services\Calendar', function () {
            return new Calendar(
                new EluceoCalendar('TypiCMS'),
                new EluceoEvent
            );
        });

    }
}
