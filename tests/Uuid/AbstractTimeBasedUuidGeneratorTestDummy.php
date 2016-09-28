<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\AbstractTimeBasedUuidGenerator;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class AbstractTimeBasedUuidGeneratorTestDummy extends AbstractTimeBasedUuidGenerator
{
    /**
     * {@inheritdoc}
     */
    const LENGTH_CHECK_DIGIT = 2;
}
