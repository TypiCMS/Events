<?php

namespace TypiCMS\Modules\Events\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Events\Composers\SidebarViewComposer;
use TypiCMS\Modules\Events\Facades\Events;
use TypiCMS\Modules\Events\Models\Event;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/events.php', 'typicms.modules.events');

        $this->loadRoutesFrom(__DIR__ . '/../routes/events.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'events');

        $this->publishes([__DIR__ . '/../../database/migrations/create_events_table.php.stub' => getMigrationFileName('create_events_table')], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../database/migrations/create_registrations_table.php.stub' => getMigrationFileName('create_registrations_table')], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/events')], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        AliasLoader::getInstance()->alias('Events', Events::class);

        // Observers
        Event::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('events::public.*', function ($view) {
            $view->page = getPageLinkedToModule('events');
        });
    }

    public function register(): void
    {
        $this->app->bind('Events', Event::class);
    }
}
