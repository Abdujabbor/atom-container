<?php
/**
 * @link http://www.atomframework.net/
 * @copyright Copyright (c) 2017 Safarov Alisher
 * @license https://github.com/atomwares/atom-container/blob/master/LICENSE (MIT License)
 */

namespace Atom\Container;

/**
 * Class Service
 *
 * @package Atom\Container
 */
class Service
{
    /**
     * @var mixed
     */
    protected $entry;
    /**
     * @var object
     */
    protected $instance;
    /**
     * @var array
     */
    protected $args = [];

    /**
     * Service constructor.
     *
     * @param mixed $entry
     * @param array $args
     */
    public function __construct($entry, array $args = [])
    {
        $this->entry = $entry;
        $this->args = $args;
    }

    /**
     * @param callable $callable
     *
     * @return $this
     */
    public function modify(callable $callable)
    {
        $callable($this->instance());

        return $this;
    }

    /**
     * @return mixed
     */
    public function instance()
    {
        if ($this->instance === null) {
            if (is_string($this->entry) && class_exists($this->entry)) {
                $this->instance = $this->args ? new $this->entry(...$this->args) : new $this->entry();
            } else {
                $this->instance = $this->entry;
            }
        }

        return $this->instance;
    }
}
