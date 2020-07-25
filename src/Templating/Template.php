<?php

namespace FTPApp\Templating;

class Template
{
    /** @var string */
    protected $path;

    /** @var $vars */
    protected $vars;

    /**
     * Template constructor.
     *
     * @param $path
     * @param $vars
     *
     * @throws TemplateException
     */
    public function __construct($path, $vars)
    {
        $path = $path . '.html';
        if (file_exists($path)) {
            $this->path = $path;
            $this->vars = $vars;
        } else {
            throw new TemplateException("Template [$path] not found.");
        }
    }

    /**
     * Renders the template.
     *
     * @return string|false
     */
    public function render()
    {
        $content = file_get_contents($this->path);

        if ($content) {
            return $this->injectVars($content);
        }

        return false;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function assign($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
     * Injects the variables in template markup.
     *
     * @param $content
     *
     * @return string
     */
    protected function injectVars($content)
    {
        $injected = $content;

        if ($varsNames = preg_match_all('/({\s?.*\s?})/', $content, $matches)) {
            array_shift($matches);

            $subject = $content;
            foreach ($this->vars as $varKey => $varValue) {
                foreach ($matches[0] as $match) {
                    $varName = preg_replace('/([{}\s+])/', '', $match);
                    if ($varKey === $varName) {
                        $regex = "/({\s?$varName\s?})/";
                        $injected = preg_replace($regex, $varValue, $subject);
                        $subject = $injected;
                    }
                }
            }
        }

        return $injected;
    }
}