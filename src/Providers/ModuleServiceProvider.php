<?php

namespace TypiCMS\Modules\Events\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Events\Composers\SidebarViewComposer;
use TypiCMS\Modules\Events\Facades\Events;
use TypiCMS\Modules\Events\Models\Event;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Collection::macro('plans', function () {
            $data = [];
            if (isset($this->items['name'], $this->items['fee'])) {
                foreach ($this->items['name'] as $key => $name) {
                    $data[] = [
                        'name' => $name,
                        'fee' => $this->items['fee'][$key],
                    ];
                }
            }

            return $data;
        });

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.events');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['events' => ['linkable_to_page', 'has_taxonomies']], $modules));

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'events');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_events_table.php.stub' => getMigrationFileName('create_events_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/events'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/scss' => resource_path('scss'),
        ], 'resources');

        AliasLoader::getInstance()->alias('Events', Events::class);

        // Observers
        Event::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('events::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('events');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Events', Event::class);
    }
}
