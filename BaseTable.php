<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;
use Closure;

abstract class BaseTable extends Tag
{

    const TABLE_HEADER = TableHeader::class;

    const TABLE_FOOTER = TableFooter::class;

    const TABLE_BODY = TableBody::class;

    const TABLE_COLUMN = TableColumn::class;

    public $renderEmpty = false;

    public $column = [];

    public $defaultColumn = [];

    public $tag = 'table';

    public $header = [];

    public $footer = [];

    public $body = [];

    public $defaultHeader = [
        'row' => [
            'column' => [
                'tag' => 'th'
            ]
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
        $body = $this->getBody();

        $content = $body->render();

        $content = $this->getHeader()->render() . $content . $this->getFooter()->render();

        return $content;
    }

    protected function createBody(array $params = [])
    {
        $params = HtmlHelper::mergeOptions($this->defaultBody, $this->body, $params);

        $class = static::TABLE_BODY;

        $body = new $class($this);

        foreach($params as $key => $value)
        {
            $body->$key = $value;
        }

        $body->getRows(); // create rows

        return $body;
    }

    protected function createHeader(array $params = [])
    {
        $params = HtmlHelper::mergeOptions($this->defaultHeader, $this->header, $params);

        $class = static::TABLE_HEADER;

        $header = new $class($this);

        foreach($params as $key => $value)
        {
            $header->$key = $value;
        }

        $header->getRows(); // create rows

        return $header;
    }

    protected function createFooter(array $params = [])
    {
        $params = HtmlHelper::mergeOptions($this->defaultFooter, $this->footer, $params);

        $class = static::TABLE_FOOTER;

        $footer = new $class($this);

        foreach($params as $key => $value)
        {
            $footer->$key = $value;
        }

        $footer->getRows(); // create rows

        return $footer;
    }

    public function createColumn(array $params = [])
    {
        $params = HtmlHelper::mergeOptions($this->defaultColumn, $this->column, $params);

        if (array_key_exists('class', $params))
        {
            $class = $params['class'];

            unset($params['class']);
        }
        else
        {
            $class = static::TABLE_COLUMN;
        }

        $column = new $class($this);

        foreach($params as $key => $value)
        {
            $column->$key = $value;
        }

        return $column;
    }

}