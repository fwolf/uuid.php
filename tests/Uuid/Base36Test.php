<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base36;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base36Test extends PHPUnitTestCase
{
    /**
     * @return MockObject | Base36
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(Base36::class)
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

        $uuid = '1b6hl42d8j01a5pgb2dd1ntu6';
        $explanation = $generator->explain($uuid);
        $this->assertEquals('2016-09-28 18:23:53', $explanation->getSecond());
        $this->assertEquals('553347', $explanation->getMicrosecond());
    }
}
