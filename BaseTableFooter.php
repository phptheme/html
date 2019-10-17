<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Helpers\Html;

abstract class BaseTableFooter extends \PhpTheme\Core\Widget
{

    public $table; // parent table

    public $tag = 'tfoot';

    public $options = [];

    public $defaultOptions = [];

    public function run()
    {
        $content = '';

        $empty = true;

        foreach($this->table->rowColumns($this->table->defaultRow) as $column)
        {
            $column->row = $this->table->defaultRow;
            
            if ($column->getFooter())
            {
                $empty = false;
            }

            $content .= $column->renderFooter();
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