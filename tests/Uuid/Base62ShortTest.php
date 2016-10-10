<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base62Short;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base62ShortTest extends PHPUnitTestCase
{
    /**
     * @return  MockObject | Base62Short
     */
    public function buildMock()
    {
        $mock = $this->getMockBuilder(Base62Short::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testGenerate()
    {
        $generator = $this->buildMock();

        $uuid = $generator->generate();
        $explanation = $generator->explain($uuid);

        $this->assertTrue(1000000 > $explanation->getSecond());
        $this->assertTrue(0 <= $explanation->getRandom());
        $this->assertEmpty($explanation->getCustom());
    }
}
