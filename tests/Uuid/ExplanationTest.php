<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\Explanation;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class ExplanationTest extends PHPUnitTestCase
{
    /**
     * @return MockObject | Explanation
     */
    protected function buildMock()
    {
        $mock = $this->getMockBuilder(Explanation::class)
            ->setMethods(null)
            ->getMock();

        return $mock;
    }


    public function testAccessors()
    {
        $explanation = (new Explanation())
            ->setSecond('57eb6c44')
            ->setMicrosecond('8df0')
            ->setGroup('0001')
            ->setCustom('60b4')
            ->setRandom('331757be44d3')
            ->setCheckDigit('')
            ->setVerified(true);

        $this->assertArrayHasKey(
            Explanation::COL_SECOND,
            $explanation->toArray()
        );
    }
}
