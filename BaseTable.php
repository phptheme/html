<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;
use Closure;

abstract class BaseTable extends Tag
{

    protected $tableRowClass = Tag::class;

    protected $tableHeaderClass = TableHeader::class;

    protected $tableFooterClass = TableFooter::class;

    protected $tableBodyClass = TableBody::class;

    protected $tableColumnClass = TableColumn::class;

    public $rowOptions = ['tag' => 'tr'];

    public $rows = [];

    public $columns = [];

    public $defaultOptions = [];

    public $options = [];

    public $header = [];

    public $headerOptions = [];

    public $footer = [];

    public $footerOptions = [];

    public $body = [];

    public $bodyOptions = [];

    public $columnOptions = [];

    public function renderRow($content)
    {
        $options = HtmlHelper::mergeAttributes($this->rowOptions, ['content' => $content]);

        return $this->theme->widget($this->tableRowClass, $options);
    }

    public function rowColumns($row)
    {
        $columns = $this->columns;

        if ($columns instanceof Closure)
        {
            $columns = $columns->bindTo($this);

            $columns = $columns($row);
        }

        return $columns;
    }

    protected function renderHeader()
    {
        $options = HtmlHelper::mergeAttributes(
            $this->headerOptions, 
            $this->header,
            [
                'table' => $this
            ]
        );

        return $this->theme->widget($this->tableHeaderClass, $options);
    }

    protected function renderFooter()
    {
        $options = HtmlHelper::mergeAttributes(
            $this->defaultFooterOptions, 
            $this->footer,
            [
                'table' => $this
            ]
        ); 

        return $this->theme->widget($this->tableFooterClass, $options);
    }

    protected function renderBody()
    {
        $options = HtmlHelper::mergeAttributes(
            $this->bodyOptions, 
            $this->body, 
            [
                'table' => $this
            ]
        );

        return $this->theme->widget($this->tableBodyClass, $options);
    }

    public function createColumn($options = [])
    {
        $options = HtmlHelper::mergeAttributes($this->columnOptions, $options);

        if (array_key_exists('class', $options))
        {
            $class = $options['class'];

            unset($options['class']);
        }
        else
        {
            $class = $this->tableColumnClass;
        }

        return $this->theme->createWidget($class, $options);
    }

    protected function prepareColumns()
    {
        foreach($this->columns as $key => $column)
        {
            if (is_string($column))
            {
                $column = ['content' => $column];
            }

            if (is_array($column))
            {
                $column = $this->createColumn($column);
            }

            $this->columns[$key] = $column;
        }
    }

    public function run()
    {
        $this->prepareColumns();

        $content = $this->renderHeader() . $this->renderBody() . $this->renderFooter();

        $options = HtmlHelper::mergeAttributes($this->defaultOptions, $this->options);

        return Html::tag('table', $content, $options);
    }

}