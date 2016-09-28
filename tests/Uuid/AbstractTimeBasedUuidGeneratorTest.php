<?php
namespace FwolfTest\Util\Uuid;

use Fwolf\Util\Uuid\AbstractTimeBasedUuidGenerator;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as PHPUnitTestCase;

/**
 * @copyright   Copyright 2013-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class AbstractTimeBasedUuidGeneratorTest extends PHPUnitTestCase
{
    /**
     * @return MockObject | AbstractTimeBasedUuidGenerator
     */
    public function buildMock()
    {
        $mock = $this->getMockBuilder(AbstractTimeBasedUuidGenerator::class)
            ->getMockForAbstractClass();

        return $mock;
    }


    /**
     * @return MockObject | AbstractTimeBasedUuidGeneratorTestDummy
     */
    public function buildMockWithCheckDigit()
    {
        $mock = $this
            ->getMockBuilder(AbstractTimeBasedUuidGeneratorTestDummy::class)
            ->getMockForAbstractClass();

        return $mock;
    }


    public function testGenerate()
    {
        $generator = $this->buildMock();

        $uuid = $generator->generate('24', 'halo');
        $this->assertTrue($generator->verify($uuid));

        $explanation = $generator->explain($uuid);
        $this->assertEquals('0024', $explanation->getGroup());
        $this->assertEquals('halo', $explanation->getCustom());
        $this->assertTrue($explanation->isVerified());
    }


    public function testGenerateWithCheckDigit()
    {
        $generator = $this->buildMockWithCheckDigit();

        // And custom param is empty
        $uuid = $generator->generate('24', '');
        $this->assertTrue($generator->verify($uuid));

        $explanation = $generator->explain($uuid);
        $this->assertTrue($explanation->isVerified());
        $this->assertNotEquals('halo', $explanation->getCustom());
    }


    public function testVerify()
    {
        $generator = $this->buildMock();

        // Check digit should be '79'
        $uuid = '57ea499a-0000-0024-halo-c53c6ed62b70';
        $this->assertTrue($generator->verify($uuid));

        // Length does not fit
        $uuid = '57ea499a-0000-0024-halo-c53c6ed62b';
        $this->assertFalse($generator->verify($uuid));
    }


    public function testVerifyWithCheckDigitEnabled()
    {
        $generator = $this->buildMockWithCheckDigit();

        // Check digit should be '79'
        $uuid = '57ea499a-0000-0024-halo-c53c6ed62b70';
        $this->assertFalse($generator->verify($uuid));

        // Length does not fit
        $uuid = '57ea499a-0000-0024-halo-c53c6ed62b';
        $this->assertFalse($generator->verify($uuid));
    }
}
