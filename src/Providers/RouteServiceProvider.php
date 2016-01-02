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
                foreach (config('translatable.locales') as $lang) {
                    if ($uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.events', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.events.slug', 'uses' => 'PublicController@show']);
                        $router->get($uri.'/{slug}/ics', $options + ['as' => $lang.'.events.slug.ics', 'uses' => 'PublicController@ics']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/events', ['as' => 'admin.events.index', 'uses' => 'AdminController@index']);
            $router->get('admin/events/create', ['as' => 'admin.events.create', 'uses' => 'AdminController@create']);
            $router->get('admin/events/{event}/edit', ['as' => 'admin.events.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/events', ['as' => 'admin.events.store', 'uses' => 'AdminController@store']);
            $router->put('admin/events/{event}', ['as' => 'admin.events.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/events', ['as' => 'api.events.index', 'uses' => 'ApiController@index']);
            $router->put('api/events/{event}', ['as' => 'api.events.update', 'uses' => 'ApiController@update']);
            $router->delete('api/events/{event}', ['as' => 'api.events.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
