<?php

namespace FTPApp\DIC;

/**
 * A very simple dependency injector container
 */
class DIC
{
    protected $definitions = [];

    /**
     * DIC constructor.
     *
     * @param array $definitions
     */
    public function __construct($definitions = [])
    {
        $this->definitions = $definitions;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param array $definitions
     */
    public function setDefinitions($definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * @param string $name
     * @param string $callback
     *
     * @return void
     */
    public function set($name, $callback)
    {
        $this->definitions[$name] = $callback();
    }

    /**
     * @param string $name
     * @param string $callback
     *
     * @return void
     */
    public function factory($name, $callback)
    {
        $this->definitions[$name] = $callback;
    }

    /**
     * @param string $name
     *
     * @return object
     */
    public function get($name)
    {
        if (is_callable($this->definitions[$name])) {
            return $this->definitions[$name]();
        }

        return $this->definitions[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->definitions);
    }
}