<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;

abstract class BaseTableBody extends \PhpTheme\Core\Widget
{

    public $table; // parent table

    public $tag = 'tbody';

    public $options = [];

    public $defaultOptions = [];

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

}