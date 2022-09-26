<?php

/*
 * Add Base.php file
 */

function io_template_path()
{
    return Io_Wrapping::$main_template;
}

function io_template_base()
{
    return Io_Wrapping::$base;
}

class Io_Wrapping
{

    static $main_template;

    static $base;

    static function wrap($template)
    {
        self::$main_template = $template;
        self::$base = substr(basename(self::$main_template), 0, -4);
        if ('index' == self::$base)
            self::$base = false;
        $templates = array('base.php');
        if (self::$base)
            array_unshift($templates, sprintf('base-%s.php', self::$base));
        return locate_template($templates);
    }
}

add_filter('template_include', array('Io_Wrapping', 'wrap'), 99);

