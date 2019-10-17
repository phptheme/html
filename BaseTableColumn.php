<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;
use Closure;

abstract class BaseTableColumn extends Tag
{

    public $row = [];

    public $tag = 'td';

    public $options = [];

    public $defaultOptions = [];

    public $header = null;

    public $defaultHeaderOptions = [];

    public $headerTag = 'th';

    public $headerOptions = [];

    public $footer = null;

    public $footerTag = 'td';

    public $defaultFooterOptions = [];

    public $footerOptions = [];

    public $attribute;

    public function getAttributeValue()
    {
        if (is_object($this->row))
        {
            return $this->row->{$this->attribute};
        }
        else
        {
            return $this->row[$this->attribute];
        }        
    }

    public function renderAttribute()
    {
        $return = parent::renderAttribute();

        if ($return !== null)
        {
            return $return;
        }

        $return = $this->getAttributeValue();

        return $return;
    }

    public function renderContent()
    {
        $return = parent::renderContent();

        if ($return !== null)
        {
            return $return;
        }

        $content = $this->content;

        if ($content instanceof Closure)
        {
            return $content($this->row);
        }

        if ($content !== null)
        {
            return $content;
        }

        if ($this->attribute)
        {
            return $this->renderAttribute($this->attribute);
        }

        return '';        
    }

    public function run()
    {
        $content = $this->renderContent();

        $options = HtmlHelper::mergeAttributes($this->defaultOptions, $this->options);

        return HtmlHelper::tag($this->tag, $content, $options);
    }

    public function renderHeader()
    {
        $return = parent::renderHeader();

        if ($return !== null)
        {
            return $return;
        }

        $options = HtmlHelper::mergeAttributes($this->defaultHeaderOptions, $this->headerOptions);
    
        return HtmlHelper::tag($this->headerTag, $this->getHeader(), $options);
    }

    public function renderFooter()
    {
        $return = parent::renderFooter();

        if ($return !== null)
        {
            return $return;
        }

        $options = HtmlHelper::mergeAttributes($this->defaultFooterOptions, $this->footerOptions);
    
        return HtmlHelper::tag($this->footerTag, $this->getFooter(), $options);
    }

    public function getHeader()
    {
        $return = parent::getHeader();

        if ($return !== null)
        {
            return $return;
        }

        return $this->header;
    }

    public function getFooter()
    {
        $return = parent::getFooter();

        if ($return !== null)
        {
            return $return;
        }

        return $this->footer;
    }

}