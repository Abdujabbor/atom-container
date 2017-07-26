<?php
/**
 * @link http://www.atomframework.net/
 * @copyright Copyright (c) 2017 Safarov Alisher
 * @license https://github.com/atomwares/atom-container/blob/master/LICENSE (MIT License)
 */

namespace Atom\Container;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package Atom\Container
 */
class Container implements ContainerInterface, IteratorAggregate, ArrayAccess, Countable
{
    /** @var  Service[] */
    protected $container;

    /**
     * Container constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->addConfig($config);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->container);
    }

    /**
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->add($offset, $value);
    }

    /**
     * @param string $offset
     *
     * @return mixed|string
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function addConfig(array $config)
    {
        foreach ($config as $id => $entry) {
            $args = [];

            if (is_array($entry) && ! empty($entry)) {
                $values = array_values($entry);
                $entry = $values[0];

                if (isset($values[1])) {
                    $args = $values[1];
                }
            }

            $this->container[$id] = new Service($entry, $args);
        }

        return $this;
    }

    /**
     * @param string $id
     * @param mixed $entry
     * @param array $args
     *
     * @return $this
     */
    public function add($id, $entry, array $args = [])
    {
        $this->container[$id] = new Service($entry, $args);

        return $this;
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($id)
    {
        if (! $this->has($id)) {
            throw new NotFoundException(
                sprintf('Identifier %s is not defined in container', $id)
            );
        }

        $entry = $this->container[$id]->instance();

        if (is_callable($entry)) {
            return $entry($this);
        }

        return $entry;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        if (! isset($this->container[$id])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function remove($id)
    {
        if ($this->has($id)) {
            unset($this->container[$id]);
        }

        return $this;
    }

    /**
     * @param ServiceProviderInterface $serviceProvider
     *
     * @return $this
     */
    public function register(ServiceProviderInterface $serviceProvider)
    {
        $serviceProvider->register($this);

        return $this;
    }
}
