<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseTableBody extends Tag
{

    const ROW = TableRow::class;

    protected $_table;

    protected $_rows;

    public $tag = 'tbody';

    public $rows = [];

    public $row = [];

    public $defaultRow = [];

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

        $class = static::ROW;

        $column = new $class($this->_table);

        foreach($options as $key => $value)
        {
            $column->$key = $value;
        }

        return $column;
    }

}