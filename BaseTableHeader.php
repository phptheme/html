<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Helpers\Html;

abstract class BaseTableHeader extends \PhpTheme\Core\Widget
{

    public $table; // parent table

    public $tag = 'thead';

    public $options = [];

    public $defaultOptions = [];

    public function run()
    {
        $content = '';

        $empty = true;

        foreach($this->table->rowColumns($this->table->defaultRow) as $column)
        {
            $column->row = $this->table->defaultRow;

            if ($column->getHeader())
            {
                $empty = false;
            }

            $content .= $column->renderHeader();
        }

        if ($empty)
        {
            return '';
        }        

        $content = $this->table->renderRow($content);

        $options = Html::mergeOptions($this->defaultOptions, $this->options);

        return Html::tag($this->tag, $content, $options);
    }    

}