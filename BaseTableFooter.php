<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseTableFooter extends Tag
{

    const TABLE_ROW = TableRow::class;

    protected $_table;

    protected $_rows;

    public $tag = 'tfoot';

    public $rows = [];

    public $rowOptions = [];

    public $renderEmpty = false;

    public function __construct($table)
    {
        parent::__construct();

        $this->_table = $table;
    }

    public function getRows()
    {
        if ($this->_rows !== null)
        {
            return $this->_rows;
        }

        $this->_rows = [];

        foreach($this->rows as $params)
        {
            $this->_rows[] = $this->createRow($params);
        }    

        return $this->_rows;
    }    

    public function getContent()
    {
        $return = '';

        foreach($this->getRows() as $row)
        {
            $return .= $row->toString();
        }

        if ($return)
        {
            $return = PHP_EOL . $return . PHP_EOL;
        }

        return $return;
    }

    public function createRow($params)
    {
        $options = HtmlHelper::mergeOptions($this->rowOptions, $params);

        $class = static::TABLE_ROW;

        $row = new $class($this->_table);

        foreach($options as $key => $value)
        {
            $row->$key = $value;
        }

        return $row;
    }

}