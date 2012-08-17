<?php

defined('SYSPATH') OR exit('No direct script access.');

class Controller_media extends Controller_Application
{

    public function action_style()
    {
        header("Content-type: text/css");
        //empty($_SESSION['styles']) and die(NULL);
        //$styles = $_SESSION['styles'];
        $styles = $this->request->param('id');
        $styles = unserialize(base64_decode($styles));
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
        //empty($_SESSION['scripts']) and die(NULL);
        //$scripts = $_SESSION['scripts'];
        $scripts = $this->request->param('id');
        $scripts = unserialize(base64_decode($scripts));
        $content = '';
        foreach ($scripts as $file)
        {
            $content .= file_get_contents($file) . ";\n";
        }
        $content = preg_replace('/;(\s|\n|\r)*;/', ';', $content);
        die($content);
    }

}
