<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

use PhpTheme\Html\HtmlHelper;
use Closure;

abstract class BaseTableColumn extends Tag
{

    public $table;

    public $tag = 'td';

    public function __construct(Table $table)
    {
        parent::__construct();

        $this->table = $table;
    }

}