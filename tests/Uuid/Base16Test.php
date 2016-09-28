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
        $generator = $this->buildMock();

        $uuid = $generator->generate();
        $infoAr = $generator->explain($uuid);
        $this->assertRegExp('/[\d-]+ [\d:]+/', $infoAr[Base16::COL_SECOND]);
    }
}
