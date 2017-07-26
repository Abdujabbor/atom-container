<?php
/**
 * @link http://www.atomframework.net/
 * @copyright Copyright (c) 2017 Safarov Alisher
 * @license https://github.com/atomwares/atom-container/blob/master/LICENSE (MIT License)
 */

namespace Atom\Container;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 *
 * @package Atom\Container
 */
class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
}
