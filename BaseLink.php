<?php

namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseLink extends Tag
{

    public $tag = 'a';

    public $label;

    public $url;

    public $icon;

    public $iconTemplate = '<i class="{icon}"></i>{label}';

    public function getContent()
    {
        $return = $this->label;

        if ($this->icon)
        {
            $return = strtr($this->iconTemplate, [
                '{label}' => $this->label,
                '{icon}' => $this->icon
            ]);
        }

        return $return;
    }

    public function render()
    {
        if (($this->url) && ($this->tag == 'a'))
        {
            $this->options['href'] = $this->url;
        }

        return parent::render();
    }

}