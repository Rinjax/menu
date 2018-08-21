<?php
namespace Rinjax\Menu;
class Menu
{
    use RenderTrait;

    // The menu's name provided to the view - as you can have more that one
    protected $menuName;
    // the navbar wrapper (not currently used)
    protected $navbar;
    // classes applied to the navbar wrapper (not currently used)
    protected $navBarClasses = [];
    // the <ul> that will be populated with <li> items
    protected $menuList = [];
    // Classes applied directly to the main <ul> (not currently used)
    protected $ulClasses = ['nav', 'navbar-nav'];
    // the html render string to output to the view/blade template
    protected $render = '';

    public function __construct($name)
    {
        $this->menuName = $name;
    }

    public function name()
    {
        return $this->menuName;
    }

    /**
     * Add a <li> item to the menu
     *
     * @param $displayText
     * @param $route
     * @return $this
     */
    public function addLink($displayText, $route)
    {
        $item = $this->linkItem();
        $item->displayText = $displayText;
        $item->route = route($route);
        array_push($this->menuList, $item);
        $this->addActiveClass($route);
        return $this;
    }

    public function addDropdown($displayText)
    {
        $item = $this->dropdownItem();
        $item->displayText = $displayText;
        array_push($this->menuList, $item);
        return $this;
    }

    public function addDropdownLink($displayText, $route)
    {
        $item = $this->linkItem();
        $item->displayText = $displayText;
        $item->route = route($route);
        array_push(end($this->menuList)->list, $item);
        return $this;
    }

    public function addImage($altText, $path)
    {
        $item = $this->imageItem();
        $item->altText = $altText;
        $item->path = asset($path);
        array_push($this->menuList, $item);
        return $this;
    }

    public function addActiveClass($route)
    {
        if (\Request::route() && \Request::route()->getName() == $route) $this->classes(['active ']);
    }

    /**
     * Add an icon to the left side of the display text on a <li>
     *
     * @param $icon
     * @return $this
     */
    public function leftIcon($icon)
    {
        end($this->menuList)->leftIcon = $icon;
        return $this;
    }

    /**
     * Add an icon to the right side of the display text on a <li>
     *
     * @param $icon
     * @return $this
     */
    public function rightIcon($icon)
    {
        end($this->menuList)->rightIcon = $icon;
        return $this;
    }

    /**
     * Add class directly to the <li>
     *
     * @param array $classes
     * @return $this
     */
    public function classes(array $classes)
    {
        foreach ($classes as $class) {
            array_push(end($this->menuList)->classes, $class);
        }
        return $this;
    }

    /**
     * Add custom styling to the <li>
     *
     * @param array $styles
     * @return $this
     */
    public function styles(array $styles)
    {
        end($this->menuList)->styles = $styles;
        return $this;
    }

    /**
     * return a menu item object that will be turned into a <li> item in the menu
     *
     * @return object
     */
    protected function linkItem()
    {
        return (object)[
            'type' => 'link',
            'displayText' => '',
            'route' => null,
            'leftIcon' => null,
            'rightIcon' => null,
            'classes' => ['nav-item'],
            'styles' => [],
        ];
    }

    protected function dropdownItem()
    {
        return (object)[
            'type' => 'dropdown',
            'displayText' => '',
            'list' => [],
            'leftIcon' => null,
            'rightIcon' => null,
            'classes' => ['dropdown',],
            'styles' => [],
            'ulClasses' => ['dropdown-menu',],
        ];
    }

    protected function imageItem()
    {
        return (object)[
            'type' => 'image',
            'altText' => '',
            'classes' => [],
            'styles' => [],
            'path' => ''
        ];
    }
}