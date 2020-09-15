<?php

namespace FTPApp\Renderer;

class Renderer
{
    /** @var string  */
    const DEFAULT_EXTENSION = '.php';

    /** @var string */
    protected $path;

    /**
     * Renderer constructor.
     *
     * @param string $path The views directory.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Renders a view and returns the gathered content as a string.
     *
     * @param string $view
     * @param array  $params
     *
     * @return string
     */
    public function render($view, $params = [])
    {
        ob_start();

        // Extract the passed parameters as variables for the view
        extract($params);

        // Declaring an instance of this object to be available in the view
        $renderer = $this;

        // Include the view
        if (strpos($view, '.') !== false) {
            $path = $this->path . DIRECTORY_SEPARATOR . $view;
        } else {
            $path = $this->path . DIRECTORY_SEPARATOR . $view . self::DEFAULT_EXTENSION;
        }

        // Checks if the file exists before include it
        if (file_exists($path)) {
            include($path);
        } else {
            throw new RendererException("View [$path] not exists.");
        }

        // Gets the output buffer content
        $content = ob_get_contents();

        // Clean the output buffer
        ob_end_clean();

        return $content;
    }

    /**
     * Generates a relative path for the giving path parameter
     * based on the current request path.
     *
     * @param string $path
     *
     * @return string
     */
    public function path($path)
    {
        $query = str_replace('/', '\\/', $_SERVER['QUERY_STRING']);
        $uri = preg_replace('/\?/', '&', $_SERVER['REQUEST_URI'], 1);
        $result = preg_replace('/'.$query.'$|index.php$|&$/', '', $uri);
        return $result . preg_replace('/^\//', '', $path);
    }
}