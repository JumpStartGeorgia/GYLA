<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_media extends Controller_Application
{

    public function action_style()
    {
        header("Content-type: text/css");
        $styles = $_SESSION['styles'];
        $content = '';
        foreach ($styles as $file)
        {
            $content .= file_get_contents($file);
        }
        $content = str_replace('{url}/', URL::base(), $content);
        die($content);
    }

    public function action_script()
    {
        header("Content-type: text/javascript; charset=utf-8");
        $scripts = $_SESSION['scripts'];
        $content = '';
        foreach ($scripts as $file)
        {
            $content .= file_get_contents($file) . ";\n";
        }
        $content = preg_replace('/;( |\n)*;/', ';', $content);
        die($content);
    }

}
