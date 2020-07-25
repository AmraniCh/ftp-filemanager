<?php

namespace FTPApp\Controllers;

use FTPApp\Template\Template;
use FTPApp\Template\TemplateException;

abstract class Controller
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
    }

    /**
     * Renders the template and returns the gathered content as a string.
     *
     * @param string $template
     * @param array  $params
     *
     * @return string|false
     *
     * @throws TemplateException
     */
    public function render($template, $params = [])
    {
        $template = new Template($template, $params);
        return $template->render();
    }
}