<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

abstract class BaseTag
{

    public $tag;

    public $attributes = [];

    public $renderEmpty = true;

    public $content;

    public function __construct()
    {
    }

    public static function factory(array $params = [])
    {
        $class = get_called_class();

        $return = new $class;

        foreach($params as $key => $value)
        {
            $return->$key = $value;
        }

        return $return;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function render()
    {
        $content = $this->getContent();

        if (!$content && !$this->renderEmpty)
        {
            return;
        }

        return HtmlHelper::tag($this->tag, $content, $this->attributes);
    }

}