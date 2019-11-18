<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

abstract class BaseTag
{

    use FactoryTrait;

    public $tag;

    public $attributes = [];

    public $renderEmpty = true;

    public $content;

    public function __construct()
    {
    }

    public function getContent()
    {
        return $this->content;
    }

    public function toString() : string
    {
        $content = $this->getContent();

        if (!$content && !$this->renderEmpty)
        {
            return '';
        }

        return HtmlHelper::tag($this->tag, $content, $this->attributes);        
    }

    public function __toString()
    {
        return $this->toString();
    }

}