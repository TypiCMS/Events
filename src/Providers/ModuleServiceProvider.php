<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Events\Providers;

use Override;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Events\Composers\SidebarViewComposer;

class ModuleServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/events.php', 'typicms.modules.events');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/events.php');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'events');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_events_table.php.stub' => getMigrationFileName(
                'create_events_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([
            __DIR__.'/../../database/migrations/create_registrations_table.php.stub' => getMigrationFileName(
                'create_registrations_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/events')], 'typicms-views');
        $this->publishes([__DIR__.'/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('events::public.*', function ($view): void {
            $view->page = getPageLinkedToModule('events');
        });
    }
}
