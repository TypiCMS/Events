<?php
namespace TypiCMS\Modules\Events\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('events', [
            'weight' => config('typicms.events.sidebar.weight'),
            'request' => $view->prefix . '/events*',
            'route' => 'admin.events.index',
            'icon-class' => 'icon fa fa-fw fa-calendar',
            'title' => 'Events',
        ]);
    }
}
