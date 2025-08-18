<?php

namespace TypiCMS\Modules\Events\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use TypiCMS\Modules\Sidebar\SidebarGroup;
use TypiCMS\Modules\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view): void
    {
        if (Gate::denies('read events')) {
            return;
        }
        $view->offsetGet('sidebar')->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Events'), function (SidebarItem $item) {
                $item->id = 'events';
                $item->icon = config('typicms.modules.events.sidebar.icon');
                $item->weight = config('typicms.modules.events.sidebar.weight');
                $item->route('admin::index-events');
            });
        });
    }
}
