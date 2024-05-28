<?php

namespace Modules\FreightManagementSystem\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'FreightManagementSystem';
        $menu = $event->menu;
        $menu->add([
            'category' => 'General',
            'title' => __('Freight Dashboard'),
            'icon' => '',
            'name' => 'freight-dashboard',
            'parent' => 'dashboard',
            'order' => 230,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'freight.dashboard',
            'module' => $module,
            'permission' => 'freight dashboard manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Freight'),
            'icon'  => 'plane-departure',
            'name'  => 'freight-management-system',
            'parent'=> null,
            'order' => 684,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'freight management system manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Customer'),
            'icon' => '',
            'name' => 'customer',
            'parent' => 'freight-management-system',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'customers.index',
            'module' => $module,
            'permission' => 'freight customer manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Booking'),
            'icon' => '',
            'name' => 'booking',
            'parent' => 'freight-management-system',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'booking-request.index',
            'module' => $module,
            'permission' => 'booking request manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Shipping'),
            'icon' => '',
            'name' => 'shipping',
            'parent' => 'freight-management-system',
            'order' => 30,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'shipping.index',
            'module' => $module,
            'permission' => 'shipping manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('Invoice'),
            'icon' => '',
            'name' => 'invoice',
            'parent' => 'freight-management-system',
            'order' => 40,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'freight-invoice.index',
            'module' => $module,
            'permission' => 'freight invoice manage'
        ]);
        $menu->add([
            'category' => 'Operations',
            'title' => __('System Setup'),
            'icon' => '',
            'name' => 'system-setup',
            'parent' => 'freight-management-system',
            'order' => 50,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'price.index',
            'module' => $module,
            'permission' => 'price manage'
        ]);
       
    }
}
