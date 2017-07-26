<?php
/**
 * @link http://www.atomframework.net/
 * @copyright Copyright (c) 2017 Safarov Alisher
 * @license https://github.com/atomwares/atom-container/blob/master/LICENSE (MIT License)
 */

namespace Atom\Container;

/**
 * Interface ServiceProviderInterface
 *
 * @package Atom\Container
 */
interface ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container);
}
