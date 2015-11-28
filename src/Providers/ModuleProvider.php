<?php

namespace TypiCMS\Modules\Events\Providers;

use Eluceo\iCal\Component\Calendar as EluceoCalendar;
use Eluceo\iCal\Component\Event as EluceoEvent;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\EventTranslation;
use TypiCMS\Modules\Events\Repositories\CacheDecorator;
use TypiCMS\Modules\Events\Repositories\EloquentEvent;
use TypiCMS\Modules\Events\Services\Calendar;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.events'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['events' => ['linkable_to_page', 'linkable_to_slide']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'events');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'events');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/events'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Events',
            'TypiCMS\Modules\Events\Facades\Facade'
        );

        // Observers
        EventTranslation::observe(new SlugObserver());
        Event::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Events\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Events\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('events::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('events');
        });

        $app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function (Application $app) {
            $repository = new EloquentEvent(new Event());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'events', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        /*
         * Calendar service
         */
        $app->bind('TypiCMS\Modules\Events\Services\Calendar', function () {
            return new Calendar(
                new EluceoCalendar('TypiCMS'),
                new EluceoEvent()
            );
        });
    }
}
