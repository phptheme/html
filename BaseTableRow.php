<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Helpers\Html;

abstract class BaseTableRow extends Tag
{

    public $tag = 'tr';

    public $columns = [];

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

                $column = $this->_table->createColumn($params);
            }

            $return .= $column->render();
        }

        return $return;
    }

}