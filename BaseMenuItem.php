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

    public $tag = 'li';

    public $activeOptions = [];

    public $url;

    public $label;

    public $activeTag;

    // link

    public $linkOptions = []; // virtual

    public $link = [];

    public $defaultLink = [];

    public $activeLink = [];

    public $linkTag = 'a';

    public $activeLinkTag = 'a';

    public $icon;

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

        $options = [];

        $options['icon'] = $this->icon;

        if ($this->active)
        {
            $options = HtmlHelper::mergeAttributes($options, $this->activeLink);
        
            $options['tag'] = $this->activeLinkTag;
        }
        else
        {
            $options['tag'] = $this->linkTag;
        }

        $options['label'] = $this->label;

        $options['url'] = $this->url;

        $options = HtmlHelper::mergeAttributes(
            $this->defaultLink, 
            $options, 
            $this->link, 
            [
                'options' => $this->linkOptions
            ]
        );

        $this->_link = $this->createLink($options);

        return $this->_link;
    }

    protected function createLink(array $options = [])
    {
        $options = HtmlHelper::mergeAttributes($this->defaultLink, $this->link, $options);

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