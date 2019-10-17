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

    public function getContent()
    {
        $return = '';

        foreach($this->rows as $params)
        {
            $row = $this->createRow($params);

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


    /*



    public function run()
    {
        $content = '';

        foreach($this->table->rows as $row)
        {
            $rowContent = '';

            foreach($this->table->rowColumns($row) as $column)
            {
                $column->row = $row;

                $rowContent .= $column->run();
            }

            $content .= $this->table->renderRow($rowContent);
        }

        $options = HtmlHelper::mergeAttributes($this->defaultOptions, $this->options);

        return HtmlHelper::tag($this->tag, $content, $options);
    }
    */


}