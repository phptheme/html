<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

abstract class BaseTableRow extends Tag
{

    public $tag = 'tr';

    public $columns = [];

    public $column = [];

    public $defaultColumn = [];

    protected $_table;

    public function __construct($table)
    {
        parent::__construct();

        $this->_table = $table;
    }

    public function getContent()
    {
        $return = '';

        foreach($this->columns as $params)
        {
            if (is_object($params))
            {
                $column = $params;
            }
            else
            {
                if (!is_array($params))
                {
                    $params = ['content' => $params];
                }

                $column = $this->createColumn($params);
            }

            $return .= $column->render();
        }

        if ($return)
        {
            $return = PHP_EOL . $return . PHP_EOL;
        }

        return $return;
    }

    public function createColumn(array $params = [])
    {
        $params = HtmlHelper::mergeAttributes($this->defaultColumn, $this->column, $params);

        return $this->_table->createColumn($params);        
    }

}