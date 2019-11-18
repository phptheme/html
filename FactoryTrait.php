<?php
/**
 * @author PhpTheme Dev Team
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\Html;

trait FactoryTrait
{

    public static function factory(array $params = [])
    {
        $class = get_called_class();

        $return = new $class;

        foreach($params as $key => $value)
        {
            $return->$key = $value;
        }

        return $return;
    }

}