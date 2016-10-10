<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base16;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2008-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base16Test extends PHPUnitTestCase
{
    /**
     * @return MockObject | Base16
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(Base16::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testExplain()
    {
        date_default_timezone_set('Asia/Shanghai');

        $generator = $this->buildMock();

        $uuid = '57eb6c44-8df0-0001-60b4-331757be44d3';
        $explanation = $generator->explain($uuid);
        $this->assertEquals('2016-09-28 15:07:48', $explanation->getSecond());
        $this->assertEquals('72672', $explanation->getMicrosecond());
    }
}
