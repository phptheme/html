<?php
/**
 * @copyright Copyright (c) 2018-2019 PhpTheme Dev Team
 * @link http://getphptheme.com
 * @license MIT License
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

    public $defaultLinkOptions = [];

    public $activeLinkOptions = [];

    public $linkTag = 'a';

    public $activeLinkTag = 'a';

    public $linkIconTemplate = null;

    // submenu

    public $defaultSubmenu = [];

    public $submenu = [];

    public $items = [];

    protected $_submenu;

    protected $_link;

    public function getLink()
    {
        if ($this->_link !== null)
        {
            return $this->_link;
        }

        $link = [
            'url' => $this->url,
            'label' => $this->label,
            'icon' => $this->icon,
            'options' => HtmlHelper::mergeAttributes($this->defaultLinkOptions, $this->linkOptions)
        ];

        if ($this->linkIconTemplate)
        {
            $link['iconTemplate'] = $this->linkIconTemplate;
        }

        if ($this->active)
        {
            $link['options'] = HtmlHelper::mergeAttributes($link['options'], $this->activeLinkOptions);
        
            $link['tag'] = $this->activeLinkTag;
        }
        else
        {
            $link['tag'] = $this->linkTag;
        }

        $this->_link = $this->createLink($link);

        return $this->_link;
    }

    protected function createLink(array $options = [])
    {
        $class = static::LINK;

        return $class::factory($options);
    }

    protected function createSubmenu(array $options = [])
    {
        $options = HtmlHelper::mergeAttributes($this->defaultSubmenu, $this->submenu, $options);

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
            $this->options = HtmlHelper::mergeAttributes($this->options, $this->activeOptions);
        }

        return parent::render();
    }    

}