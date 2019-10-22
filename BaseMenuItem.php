<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseMenuItem extends \PhpTheme\Html\Tag
{

    const LINK = Link::class;

    const SUBMENU = Menu::class;

    public $active; //is active

    public $icon;

    public $tag = 'li';

    public $activeOptions = [];

    public $url;

    public $label;

    public $activeTag;

    // link

    public $linkOptions = [];

    public $activeLinkOptions = [];

    // submenu

    public $submenuOptions = [];

    public $items = [];

    protected $_submenu;

    protected $_link;

    public function getLink()
    {
        if ($this->_link !== null)
        {
            return $this->_link;
        }

        $this->_link = $this->createLink($link);

        return $this->_link;
    }

    protected function createLink(array $options = [])
    {
        $linkOptions = [
            'url' => $this->url,
            'label' => $this->label
        ];

        if ($this->icon)
        {
            $linkOptions['icon'] = $this->icon;
        }

        $linkOptions = HtmlHelper::mergeOptions($linkOptions, $this->linkOptions);

        if ($this->active)
        {
            $linkOptions = HtmlHelper::mergeOptions($this->activeLinkOptions);
        }

        $linkOptions = HtmlHelper::mergeOptions($linkOptions, $options);

        $class = static::LINK;

        return $class::factory($options);
    }

    protected function createSubmenu(array $options = [])
    {
        $options = HtmlHelper::mergeOptions($this->submenuOptions, $options);

        $class = static::SUBMENU;

        return $class::factory($options);
    }

    public function getSubmenu()
    {
        if ($this->_submenu !== null)
        {
            return $this->_submenu;
        }

        if ($this->items)
        {
            $this->_submenu = $this->createSubmenu(['items' => $this->items]);
        }

        return $this->_submenu;
    }

    public function getContent()
    {
        $content = '';

        $content .= $this->getLink()->render();

        $submenu = $this->getSubmenu();

        if ($submenu)
        {
            $content .= $submenu->render();
        }

        return $content;
    }

    public function render()
    {
        if ($this->active)
        {
            $this->options = HtmlHelper::mergeOptions($this->options, $this->activeOptions);
        }

        return parent::render();
    }    

}