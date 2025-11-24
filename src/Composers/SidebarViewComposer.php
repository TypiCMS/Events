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
        $view->offsetGet('sidebar')->group(__(config('typicms.modules.contacts.sidebar.group', 'Content')), function (SidebarGroup $group): void {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__(config('typicms.modules.events.sidebar.label', 'Events')), function (SidebarItem $item): void {
                $item->id = 'events';
                $item->icon = config('typicms.modules.events.sidebar.icon');
                $item->weight = config('typicms.modules.events.sidebar.weight');
                $item->route('admin::index-events');
            });
        });
    }
}
