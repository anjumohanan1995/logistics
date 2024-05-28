<?php

namespace Modules\Quotation\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'Quotation';
        $menu = $event->menu;
        $menu->add([
            'title' => 'Quotation Print Setting',
            'name' => 'quotation-setting',
            'order' => 260,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'quotation-sidenav',
            'module' => $module,
            'permission' => 'quotation manage'
        ]);
    }
}
