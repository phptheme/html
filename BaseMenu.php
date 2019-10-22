<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseMenu extends \PhpTheme\Html\Tag
{

    const MENU_ITEM = MenuItem::class;

    public $items = [];

    public $item = [];

    public $defaultItem = [];

    public $renderEmpty = false;

    protected $_items;

    protected function createItem(array $params = [])
    {
        if ($this->itemIsActive($params))
        {
            $params['active'] = true;
        }

        $params = HtmlHelper::mergeOptions($this->defaultItem, $this->item, $params);

        $class = static::MENU_ITEM;

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

    public function getItems()
    {
        if ($this->_items !== null)
        {
            return $this->_items;
        }

        $this->_items = [];

        foreach($this->items as $key => $params)
        {
            $this->_items[$key] = $this->createItem($params);
        }

        return $this->_items;
    }

    public function getContent()
    {
        $items = $this->getItems();

        $content = '';

        foreach($items as $item)
        {
            $content .= $item->render();
        }

        return $content;
    }

}