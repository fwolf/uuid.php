<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base36Short;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2015-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base36ShortTest extends PHPUnitTestCase
{
    /**
     * @return  MockObject | Base36Short
     */
    public function buildMock()
    {
        $mock = $this->getMockBuilder(Base36Short::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testGenerate()
    {
        $generator = $this->buildMock();

        $uuid = $generator->generate();
        $explanation = $generator->explain($uuid);

        // Custom should not larger than half of 10{8}
        $random = base_convert($explanation->getRandom(), 36, 10);
        $this->assertLessThan(50000000, $random);

        $this->assertEmpty($explanation->getCustom());
    }
}
