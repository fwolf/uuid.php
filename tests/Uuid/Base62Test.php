<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base62;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base62Test extends PHPUnitTestCase
{
    /**
     * @return MockObject | Base62
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(Base62::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testExplain()
    {
        date_default_timezone_set('Asia/Shanghai');

        $generator = $this->buildMock();

        $uuid = $generator->generate();
        $this->assertTrue($generator->verify($uuid));

        /** @noinspection SpellCheckingInspection */
        $uuid = '1BTh3g2aLC01WohNXQDHJdGY';
        $explanation = $generator->explain($uuid);
        $this->assertEquals('2016-10-10 00:34:14', $explanation->getSecond());
        $this->assertEquals('518048', $explanation->getMicrosecond());
    }
}
