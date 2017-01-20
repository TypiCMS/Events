<?php

namespace TypiCMS\Modules\Events\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(__('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(__('events::global.name'), function (SidebarItem $item) {
                $item->id = 'events';
                $item->icon = config('typicms.events.sidebar.icon', 'icon fa fa-fw fa-calendar');
                $item->weight = config('typicms.events.sidebar.weight');
                $item->route('admin::index-events');
                $item->append('admin::create-event');
                $item->authorize(
                    Gate::allows('index-events')
                );
            });
        });
    }
}
