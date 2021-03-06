<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;

class NavigationComponent extends Component
{
    private static $_items = [];

    /**
     * Adds the tabs to the page before it renders
     *
     * @return void
     */
    public function beforeRender()
    {
        $controller = $this->_registry->getController();

        $this->addToController($controller);
    }

    /**
     * Adds the tabs to the page before it renders
     *
     * @param Controller $controller The controller
     * @return void
     */
    public function addToController(Controller $controller)
    {
        foreach (self::$_items as $key => $item) {
            self::$_items[$key]['active'] = $this->_isActive($item['title'], $controller);
        }

        $controller->set('navigation', ['tabs' => self::$_items]);
    }

    /**
     * Adds a tab to the navigation bar
     *
     * @param  string $title The title of the tab
     * @param  string $href  The link of the tab
     * @return void
     */
    public static function addTab($title, $href)
    {
        array_push(self::$_items, ['title' => $title, 'href' => $href]);
    }

    /**
     * Checks if the tab is active
     *
     * @param  string        $name       The name of the tab to check
     * @param  Controller $controller The current controller
     * @return bool If the specified tab is active
     */
    protected function _isActive($name, Controller $controller)
    {
        return strtolower($name) == strtolower($controller->name);
    }
}
