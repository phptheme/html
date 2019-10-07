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

    public $options = [];

    public $defaultOptions = [];

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

        $options = HtmlHelper::mergeOptions($this->defaultOptions, $this->options);

        return HtmlHelper::tag($this->tag, $this->content, $options);
    }

}