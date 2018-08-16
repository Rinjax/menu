<?php
namespace App\Packages\Menu;
trait RenderTrait
{
    /**
     * the main render method that returns the complete HTML code
     *
     * @return mixed
     */
    public function render()
    {
        foreach ($this->menuList as $item) {
            if ($item->type == 'link') $this->renderLink($item);
            if ($item->type == 'dropdown') $this->renderDropdown($item);
            if ($item->type == 'image') $this->renderImage($item);
        }
        return $this->render;
    }

    protected function renderLink($item)
    {
        $this->render .= $this->liOpening();
        $this->render .= $this->liClasses($item->classes);
        if (count($item->styles) > 0) $this->render .= $this->liStyles($item->styles);
        $this->render .= $this->tagClose();
        $this->render .= $this->aTagOpening($item->route);
        $this->render .= $item->displayText;
        $this->render .= $this->liAndAClosing();
    }

    protected function renderDropdown($item)
    {
        $this->render .= $this->liOpening();
        $this->render .= $this->liClasses($item->classes);
        if (count($item->styles) > 0) $this->render .= $this->liStyles($item->styles);
        $this->render .= $this->tagClose();
        $this->render .= $this->aTagOpeningDropdown();
        $this->render .= $item->displayText;
        $this->render .= $this->aClosing();
        $this->render .= $this->ulOpening($item->ulClasses);
        foreach ($item->list as $item) {
            $this->render .= $this->renderLink($item);
        }
        $this->render .= $this->ulClosing();
        $this->render .= $this->liClosing();
    }

    protected function renderImage($item)
    {
        $this->render .= $this->liOpening();
        $this->render .= $this->tagClose();
        $this->render .= $this->imgOpening();
        $this->render .= $this->liClasses($item->classes);
        if (count($item->styles) > 0) $this->render .= $this->liStyles($item->styles);
        $this->render .= $this->imgScr($item);
    }

    protected function liOpening()
    {
        return "<li ";
    }

    protected function tagClose()
    {
        return ">";
    }

    protected function liClasses($itemClasses)
    {
        $classes = "class='" . $this->classString($itemClasses) . "'";
        return $classes;
    }

    protected function classString(array $itemClasses)
    {
        $classes = '';
        foreach ($itemClasses as $class) {
            $classes .= $class . ' ';
        }
        return rtrim($classes);
    }

    protected function liStyles($itemStyles)
    {
        $styles = 'style="' . $this->styleString($itemStyles) . '""';
        return $styles;
    }

    protected function styleString($itemStyles)
    {
        $styles = '';
        foreach ($itemStyles as $k => $v) {
            $styles .= $k . ': ' . $v . '; ';
        }
        return rtrim($styles);
    }

    protected function aTagOpening($route)
    {
        return "<a href='" . $route . "'>";
    }

    protected function aTagOpeningDropdown()
    {
        return '<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
    }

    protected function imgOpening()
    {
        return '<img ';
    }

    protected function imgScr($item)
    {
        return ' src="' . $item->path . '" alt="' . $item->altText . '">';
    }

    protected function liAndAClosing()
    {
        return "</a></li>";
    }

    protected function liClosing()
    {
        return "</li>";
    }

    protected function ulOpening($classes)
    {
        return "<ul " . $this->liClasses($classes) . ">";
    }

    protected function ulClosing()
    {
        return "</ul>";
    }

    protected function aClosing()
    {
        return "</a>";
    }
}