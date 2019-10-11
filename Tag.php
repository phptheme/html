<?php
/**
 * @author PhpTheme Dev Team
 * @link http://getphptheme.com
 * @license MIT
 */
namespace PhpTheme\Html;

class Tag
{

    public $tag;

    public $attributes = [];

    public $defaultAttributes = [];

    public $renderEmpty = true;

    public $content;

    public function __construct()
    {
    }

    public function render()
    {
        if (!$this->content && !$this->renderEmpty)
        {
            return;
        }

        $attributes = HtmlHelper::mergeAttributes($this->defaultAttributes, $this->attributes);

        return HtmlHelper::tag($this->tag, $this->content, $attributes);
    }

}