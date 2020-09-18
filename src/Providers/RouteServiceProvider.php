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
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('events')) {
                $middleware = $page->private ? ['public', 'auth'] : ['public'];
                $router->middleware($middleware)->group(function (Router $router) use ($page) {
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, [PublicController::class, 'index'])->name($lang.'::index-events');
                            $router->get($uri.'/past', [PublicController::class, 'past'])->name($lang.'::past-events');
                            $router->get($uri.'/{slug}', [PublicController::class, 'show'])->name($lang.'::event');
                            $router->get($uri.'/{slug}/ics', [PublicController::class, 'ics'])->name($lang.'::event-ics');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('events', [AdminController::class, 'index'])->name('admin::index-events')->middleware('can:read events');
                $router->get('events/create', [AdminController::class, 'create'])->name('admin::create-event')->middleware('can:create events');
                $router->get('events/{event}/edit', [AdminController::class, 'edit'])->name('admin::edit-event')->middleware('can:update events');
                $router->get('events/{event}/files', [AdminController::class, 'files'])->name('admin::edit-event-files')->middleware('can:update events');
                $router->post('events', [AdminController::class, 'store'])->name('admin::store-event')->middleware('can:create events');
                $router->put('events/{event}', [AdminController::class, 'update'])->name('admin::update-event')->middleware('can:update events');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('events', [ApiController::class, 'index'])->middleware('can:read events');
                    $router->patch('events/{event}', [ApiController::class, 'updatePartial'])->middleware('can:update events');
                    $router->delete('events/{event}', [ApiController::class, 'destroy'])->middleware('can:delete events');
                });
            });
        });
    }
}
