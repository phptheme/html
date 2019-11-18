<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

abstract class BaseTableRow extends Tag
{

    public $tag = 'tr';

    public $columns = [];

    public $columnOptions = [];

    protected $_table;

    protected $_columns;

    public function __construct($table)
    {
        parent::__construct();

        $this->_table = $table;
    }

    public function getColumns()
    {
        if ($this->_columns !== null)
        {
            return $this->_columns;
        }

        $this->_columns = [];

        foreach($this->columns as $params)
        {
            if (is_object($params))
            {
                $this->_columns[] = $params;
            }
            else
            {
                if (!is_array($params))
                {
                    $params = ['content' => $params];
                }

                $this->_columns[] = $this->createColumn($params);
            }
        }

        return $this->_columns;
    }

    public function getContent()
    {
        $return = '';

        foreach($this->getColumns() as $column)
        {
            $return .= $column->toString();
        }

        if ($return)
        {
            $return = PHP_EOL . $return . PHP_EOL;
        }

        return $return;
    }

    public function createColumn(array $options = [])
    {
        $options = HtmlHelper::mergeOptions($this->columnOptions, $options);

        return $this->_table->createColumn($options);
    }

}