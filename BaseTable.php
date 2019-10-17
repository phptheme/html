<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;
use Closure;

abstract class BaseTable extends Tag
{

    const HEADER = TableHeader::class;

    const FOOTER = TableFooter::class;

    const BODY = TableBody::class;

    const COLUMN = TableColumn::class;

    public $renderEmpty = false;

    public $column = [];

    public $defaultColumn = [];

    public $tag = 'table';

    public $header = [];

    public $footer = [];

    public $body = [];

    public $defaultHeader = [
        'row' => [
            'tag' => 'th'
        ]
    ];

    public $defaultFooter = [
        'row' => [
            'tag' => 'tr'
        ]
    ];

    public $defaultBody = [
        'row' => [
            'tag' => 'tr'
        ]
    ];

    protected $_header;

    protected $_footer;

    protected $_body;

    public function getHeader()
    {
        if (!$this->_header)
        {
            $this->_header = $this->createHeader();
        }

        return $this->_header;
    }

    public function getFooter()
    {
        if (!$this->_footer)
        {
            $this->_footer = $this->createFooter();
        }

        return $this->_footer;
    }

    public function getBody()
    {
        if (!$this->_body)
        {            
            $this->_body = $this->createBody();
        }

        return $this->_body;
    }

    public function getContent()
    {
        $body = $this->createBody();

        $content = $this->getBody()->render();

        $content = $this->getHeader()->render() . $content . $this->getFooter()->render();

        return $content;
    }

    protected function createBody(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultBody, $this->body, $params);

        $class = static::BODY;

        $body = new $class($this);

        foreach($params as $key => $value)
        {
            $body->$key = $value;
        }

        return $body;
    }

    protected function createHeader(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultHeader, $this->header, $params);

        $class = static::HEADER;

        $header = new $class($this);

        foreach($params as $key => $value)
        {
            $header->$key = $value;
        }

        return $header;
    }

    protected function createFooter(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultFooter, $this->footer, $params);

        $class = static::FOOTER;

        $footer = new $class($this);

        foreach($params as $key => $value)
        {
            $footer->$key = $value;
        }

        return $footer;
    }

    public function createColumn(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultColumn, $this->column, $params);

        if (array_key_exists('class', $params))
        {
            $class = $params['class'];

            unset($params['class']);
        }
        else
        {
            $class = static::COLUMN;
        }

        $column = new $class($this);

        foreach($params as $key => $value)
        {
            $column->$key = $value;
        }

        return $column;
    }


}