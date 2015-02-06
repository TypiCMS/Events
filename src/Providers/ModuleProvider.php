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
use TypiCMS\Modules\Events\Services\Form\EventForm;
use TypiCMS\Modules\Events\Services\Form\EventFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addNamespace('events', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'events');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/events'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

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
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Events\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function (Application $app) {
            $repository = new EloquentEvent(new Event);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'events', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Events\Services\Form\EventForm', function (Application $app) {
            return new EventForm(
                new EventFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Events\Repositories\EventInterface')
            );
        });

        $app->bind('TypiCMS\Modules\Events\Services\Calendar', function () {
            return new Calendar(
                new EluceoCalendar('TypiCMS'),
                new EluceoEvent
            );
        });

    }
}
