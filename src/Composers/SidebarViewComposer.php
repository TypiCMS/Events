<?php
namespace TypiCMS\Modules\Events\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('events::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.events.sidebar.icon', 'icon fa fa-fw fa-calendar');
                $item->weight = config('typicms.events.sidebar.weight');
                $item->route('admin.events.index');
                $item->append('admin.events.create');
                $item->authorize(
                    $this->user->hasAccess('events.index')
                );
            });
        });
    }
}
