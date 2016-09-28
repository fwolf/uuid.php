<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Base16WithCheckDigit;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base16WithCheckDigitTest extends PHPUnitTestCase
{
    /**
     * @return MockObject | Base16WithCheckDigit
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(Base16WithCheckDigit::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testExplain()
    {
        $generator = $this->buildMock();

        $uuid = $generator->generate();
        $explanation = $generator->explain($uuid);
        $this->assertNotEmpty($explanation->getCheckDigit());
    }
}
