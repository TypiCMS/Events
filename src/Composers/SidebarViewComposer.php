<?php

namespace TypiCMS\Modules\Events\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read events')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Events'), function (SidebarItem $item) {
                $item->id = 'events';
                $item->icon = config('typicms.events.sidebar.icon');
                $item->weight = config('typicms.events.sidebar.weight');
                $item->route('admin::index-events');
                $item->append('admin::create-event');
            });
        });
    }
}
