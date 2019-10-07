<?php
/**
 * @author PhpTheme Dev Team
 * @link http://getphptheme.com
 * @license MIT
 */
namespace PhpTheme\Html;

class HtmlHelper
{

    public static function escape($string, $encoding = 'utf-8', $specialCharsFlags = null)
    {
        if (!$specialCharsFlags)
        {
            $specialCharsFlags = ENT_QUOTES | ENT_SUBSTITUTE;
        }

        return htmlspecialchars($string, $specialCharsFlags, $encoding);
    }

    public static function mergeClass($class1, $class2)
    {
        if (is_array($class2))
        {
            if (!is_array($class1))
            {
                $class1 = explode(' ', $class1);
            }

            foreach($class2 as $class)
            {
                if (array_search($class, $class1) === false)
                {
                    $class1[] = $class;
                }
            }

            return implode(' ', $class1);
        }

        return $class2;
    }

    public static function explodeStyle(string $style)
    {
        $return = [];

        $strings = explode(';', $style);

        foreach($strings as $string)
        {
            list($key, $value) = explode(':', $string);

            $return[$key] = $value;
        }

        return $return;
    }

    public static function implodeStyle(array $style)
    {
        $strings = [];

        foreach($style as $key => $value)
        {
            $strings[] = $key . ':' . $value;
        }

        return implode(';', $strings);
    }

    public static function mergeStyle($style1, $style2)
    {
        if (is_array($style2))
        {
            if (!is_array($style1))
            {
                $style1 = static::explodeStyle($style1);
            }

            foreach($style2 as $key => $value)
            {
                $style1[$key] = $value;
            }

            return static::implodeStyle($style1);
        }

        return $style2;
    }    

    public static function mergeOptions(array $array1, array $array2)
    {
        $args = func_get_args();

        $return = array_shift($args);

        if (count($args) > 1)
        {
            foreach($args as $array)
            {
                $return = static::mergeOptions($return, $array);
            }

            return $return;
        }

        foreach($array2 as $key => $value)
        {
            if (($key == 'class') && array_key_exists($key, $return))
            {
                $return[$key] = static::mergeClass($return[$key], $value);
            }
            elseif(($key == 'style') && array_key_exists($key, $return))
            {
                $return[$key] = static::mergeStyle($return[$key], $value);
            }
            else
            {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    public static function renderOptions($options) : string
    {
        $return = '';

        if (array_key_exists('class', $options) && is_array($options['class']))
        {
            $options['class'] = implode(' ', $options['class']);
        }

        if (array_key_exists('style', $options) && is_array($options['style']))
        {
            $options['style'] = static::implodeStyle($options['style']);
        }

        foreach($options as $key => $value)
        {
            $return .= ' ' . $key . '="' . $value . '"';
        }

        return $return;
    }

    public static function beginTag($tag, array $options = [])
    {
        if ($tag)
        {
            return '<' . $tag . static::renderOptions($options) . '>';
        }

        return '';
    }

    public static function endTag($tag)
    {
        if ($tag)
        {
            return '</' . $tag . '>';
        }

        return '';
    }

    public static function tag($tag, $content, array $options = [])
    {
        $return = static::beginTag($tag, $options);

        $return .= $content;

        $return .= static::endTag($tag);

        return $return;
    }

    public static function shortTag($tag, array $options = [])
    {
        return '<' . $tag . static::renderOptions($options) . '>';
    }

    public static function linkCss($href, array $options = [])
    {
        $options['rel'] = 'stylesheet';

        $options['type'] = 'text/css';

        if (!array_key_exists('media', $options))
        {
            $options['media'] = 'screen';
        }

        $options['href'] = $href;

        return static::shortTag('link', $options);
    }

    public static function scriptFile($url, array $params = [])
    {
        $params['src'] = $url;

        return static::tag('script', '', $params);
    }

}