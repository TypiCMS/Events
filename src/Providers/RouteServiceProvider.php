<?php

namespace TypiCMS\Modules\Events\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Events\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('events')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (locales() as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-events');
                        $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::event');
                        $router->get($uri.'/{slug}/ics', $options + ['uses' => 'PublicController@ics'])->name($lang.'::event-ics');
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('events', 'AdminController@index')->name('admin::index-events');
                $router->get('events/create', 'AdminController@create')->name('admin::create-event');
                $router->get('events/{event}/edit', 'AdminController@edit')->name('admin::edit-event');
                $router->post('events', 'AdminController@store')->name('admin::store-event');
                $router->put('events/{event}', 'AdminController@update')->name('admin::update-event');
                $router->patch('events/{ids}', 'AdminController@ajaxUpdate')->name('admin::update-event');
                $router->delete('events/{ids}', 'AdminController@destroyMultiple')->name('admin::destroy-event');
            });
        });
    }
}
