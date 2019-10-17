<?php
/**
 * @copyright Copyright (c) 2018-2019 PhpTheme Dev Team
 * @link http://getphptheme.com
 * @license MIT License
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseMenu extends \PhpTheme\Html\Tag
{

    protected $menuItemClass = MenuItem::class;

    public $items = [];

    public $item = [];

    public $defaultItem = [];

    public $renderEmpty = false;

    protected function createItem(array $params = [])
    {
        if ($this->itemIsActive($params))
        {
            $params['active'] = true;
        }

        $params = HtmlHelper::mergeAttributes($this->defaultItem, $this->item, $params);

        $class = $this->menuItemClass;

        return $class::factory($params);
    }

    protected function itemIsActive($item)
    {
        if (array_key_exists('active', $item))
        {
            return $item['active'];
        }

        if (array_key_exists('items', $item))
        {
            foreach($item['items'] as $k => $v)
            {
                if ($this->itemIsActive($v))
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function getContent()
    {
        $items = [];

        foreach($this->items as $key => $item)
        {
            $items[$key] = $this->createItem($item);
        }

        if (!$this->renderEmpty && !$items)
        {
            return '';
        }

        $content = '';

        foreach($items as $item)
        {
            $content .= $item->render();
        }

        return $content;
    }

}