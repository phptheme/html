<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Helpers\Html;

abstract class BaseTableHeader extends Tag
{

    const TABLE_ROW = TableRow::class;

    protected $_table;

    protected $_rows;

    public $renderEmpty = false;

    public $tag = 'thead';

    public $rows = [];

    public $row = [];

    public $defaultRow = [];

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
            $return .= $row->render();
        }

        if ($return)
        {
            $return = PHP_EOL . $return . PHP_EOL;
        }

        return $return;
    }

    public function createRow($params)
    {
        $options = HtmlHelper::mergeAttributes($this->defaultRow, $this->row, $params);

        $class = static::TABLE_ROW;

        $column = new $class($this->_table);

        foreach($options as $key => $value)
        {
            $column->$key = $value;
        }

        return $column;
    }

}