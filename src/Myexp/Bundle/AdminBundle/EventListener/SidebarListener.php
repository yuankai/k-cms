<?php

namespace Myexp\Bundle\AdminBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * 动态添加菜单
 */
class SidebarListener {

    /**
     * 
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event) {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    /**
     * Get the sidebar menu
     *
     * @param Request $request
     * @return mixed
     */
    protected function getMenu(Request $request) {
        $earg = array();
        $rootItems = array(
            $dash = new MenuItemModel('dashboard', 'Dashboard', 'admin_dashboard', $earg, 'fa fa-dashboard'),
            $admin = new MenuItemModel('admin', 'Admin', false),
                //$form = new MenuItemModel('forms', 'Forms', 'avanzu_admin_form_demo', $earg, 'fa fa-edit'),
                 // $widgets = new MenuItemModel('widgets', 'Widgets', 'avanzu_admin_demo', $earg, 'fa fa-th', 'new'), 
                //$ui = new MenuItemModel('ui-elements', 'UI Elements', '', $earg, 'fa fa-laptop')
        );
        
        $admin->addChild(new MenuItemModel('website', 'Website', 'admin_website', array(), 'fa fa-www'));

        /* $ui->addChild(new MenuItemModel('ui-elements-general', 'General', 'avanzu_admin_ui_gen_demo', $earg))
          ->addChild($icons = new MenuItemModel('ui-elements-icons', 'Icons', 'avanzu_admin_ui_icon_demo', $earg)); */

        return $this->activateByRoute($request->get('_route'), $rootItems);
    }

    /**
     * Set current menu item to be active
     *
     * @param $route
     * @param $items
     * @return mixed
     */
    protected function activateByRoute($route, $items) {

        foreach ($items as $item) { /** @var $item MenuItemModel */
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }

}
