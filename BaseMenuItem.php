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

    protected $linkClass = Link::class;

    protected $submenuClass = Menu::class;

    public $tag = 'li';

    public $activeOptions = [];

    public $linkOptions = [];

    public $defaultLinkOptions = [];

    public $activeLinkOptions = [];

    public $linkTag = 'a';

    public $activeLinkTag = 'a';

    public $url;

    public $label;

    public $activeTag;

    public $active;

    public $icon;

    public $iconTemplate = '<i class="{icon}"></i>{label}';

    public $defaultSubmenu = [];

    public $submenu = [];

    public $items = [];

    public $link = []; // new

    public $defaultLink = []; // new

    protected function renderLink()
    {
        $linkOptions = [];

        $linkOptions['icon'] = $this->icon;

        $linkOptions['iconTemplate'] = $this->iconTemplate;

        $linkOptions = HtmlHelper::mergeAttributes($this->defaultLinkOptions, $this->linkOptions, $linkOptions);

        if ($this->active)
        {
            $linkOptions = HtmlHelper::mergeAttributes($linkOptions, $this->activeLinkOptions);
        }

        if ($this->active)
        {
            $linkOptions['tag'] = $this->activeLinkTag;
        }
        else
        {
            $linkOptions['tag'] = $this->linkTag;
        }

        $linkOptions['label'] = $this->label;

        $linkOptions['url'] = $this->url;

        $link = $this->createLink($linkOptions);

        return $link->render();
    }

    public function getContent()
    {
        $options = HtmlHelper::mergeAttributes($this->defaultOptions, $this->options);

        if ($this->active)
        {
            $options = HtmlHelper::mergeAttributes($options, $this->activeOptions);
        }

        $content = $this->renderLink();

        $content .= $this->renderSubmenu();

        return $content;
    }

    protected function createLink(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultLink, $this->link, $params);

        $class = $this->linkClass;

        return $class::factory($params);
    }

    protected function createSubmenu(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultSubmenu, $this->submenu, $params);

        $class = $this->submenuClass;

        return $class::factory($params);
    }

    protected function renderSubmenu()
    {
        if (!$this->items)
        {
            return '';
        }

        $submenu = $this->createSubmenu(['items' => $this->items]);

        return $submenu->render();
    }

}