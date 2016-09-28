<?php
namespace Fwolf\Util\Uuid;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base16WithCheckDigit extends Base16
{
    /**
     * {@inheritdoc}
     */
    const LENGTH_CHECK_DIGIT = 2;
}
