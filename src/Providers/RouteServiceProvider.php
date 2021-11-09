<?php

namespace TypiCMS\Modules\Events\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Events\Http\Controllers\AdminController;
use TypiCMS\Modules\Events\Http\Controllers\ApiController;
use TypiCMS\Modules\Events\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('events')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-events');
                        $router->get('past', [PublicController::class, 'past'])->name('past-events');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('event');
                        $router->get('{slug}/ics', [PublicController::class, 'ics'])->name('event-ics');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('events', [AdminController::class, 'index'])->name('index-events')->middleware('can:read events');
            $router->get('events/export', [AdminController::class, 'export'])->name('export-events')->middleware('can:read events');
            $router->get('events/create', [AdminController::class, 'create'])->name('create-event')->middleware('can:create events');
            $router->get('events/{event}/edit', [AdminController::class, 'edit'])->name('edit-event')->middleware('can:read events');
            $router->get('events/{event}/files', [AdminController::class, 'files'])->name('edit-event-files')->middleware('can:update events');
            $router->post('events', [AdminController::class, 'store'])->name('store-event')->middleware('can:create events');
            $router->put('events/{event}', [AdminController::class, 'update'])->name('update-event')->middleware('can:update events');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('events', [ApiController::class, 'index'])->middleware('can:read events');
            $router->patch('events/{event}', [ApiController::class, 'updatePartial'])->middleware('can:update events');
            $router->delete('events/{event}', [ApiController::class, 'destroy'])->middleware('can:delete events');
        });
    }
}
