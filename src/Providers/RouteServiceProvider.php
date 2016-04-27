<?php

namespace TypiCMS\Modules\Events\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('events')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable-bootforms.locales') as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.events', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.events.slug', 'uses' => 'PublicController@show']);
                        $router->get($uri.'/{slug}/ics', $options + ['as' => $lang.'.events.slug.ics', 'uses' => 'PublicController@ics']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/events', 'AdminController@index')->name('admin::index-events');
            $router->get('admin/events/create', 'AdminController@create')->name('admin::create-event');
            $router->get('admin/events/{event}/edit', 'AdminController@edit')->name('admin::edit-event');
            $router->post('admin/events', 'AdminController@store')->name('admin::store-event');
            $router->put('admin/events/{event}', 'AdminController@update')->name('admin::update-event');

            /*
             * API routes
             */
            $router->get('api/events', 'ApiController@index')->name('api::index-events');
            $router->put('api/events/{event}', 'ApiController@update')->name('api::update-event');
            $router->delete('api/events/{event}', 'ApiController@destroy')->name('api::destroy-event');
        });
    }
}
