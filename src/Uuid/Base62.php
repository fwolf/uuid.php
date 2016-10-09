<?php
namespace Fwolf\Util\Uuid;

use Fwolf\Util\BaseConverter\BaseConverterAwareTrait;

/**
 * UUID generator using base-62 character (0-9a-zA-Z)
 *
 *
 * second: 6 chars, seconds in microtime.
 *      base_convert('ZZZZZZ', 62, 10) = 56800235583 = 3769-12-05 11:13:03
 *      base_convert('100000', 62, 10) = 916132832 = 1999-01-12 17:20:32
 *
 * microsecond: 4 chars, micro-second in microtime, multiple 1000000.
 *      base_convert(999999, 10, 62) = 4c91
 *
 * group: 2 chars
 *      base_convert('zz', 62, 10) = 3843, enough to group server.
 *
 * random: 6 chars
 *      62^6 = 56800235584, about 13x of 16^8 = 4294967296,
 *      and microsecond is 100x of general UUID.
 * (Notice: base_convert() does not allow base greater than 36.)
 *
 * Notice: Mix of a-zA-Z may not suit for Mysql UUID, because Mysql default
 * compare string CASE INSENSITIVE.
 *
 * @copyright   Copyright 2013-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base62 extends AbstractTimeBasedUuidGenerator
{
    use BaseConverterAwareTrait;


    /**
     * {@inheritdoc}
     */
    const LENGTH = 24;

    /**
     * {@inheritdoc}
     */
    const LENGTH_SECOND = 6;

    /**
     * {@inheritdoc}
     */
    const LENGTH_MICROSECOND = 4;

    /**
     * {@inheritdoc}
     */
    const LENGTH_GROUP = 2;

    /**
     * {@inheritdoc}
     */
    const LENGTH_CUSTOM = 6;

    /**
     * {@inheritdoc}
     */
    const LENGTH_RANDOM = 6;

    /**
     * {@inheritdoc}
     */
    const LENGTH_CHECK_DIGIT = 0;

    /**
     * {@inheritdoc}
     */
    const SEPARATOR = '';


    /**
     * {@inheritdoc}
     */
    public function explain($uuid)
    {
        $explanation = parent::explain($uuid);

        $converter = $this->getBaseConverter();

        $second = $converter->convert($explanation->getSecond(), 62, 10);
        $explanation->setSecond(date('Y-m-d H:i:s', $second));

        $microsecond =
            $converter->convert($explanation->getMicrosecond(), 62, 10);
        $explanation->setMicrosecond($microsecond);

        return $explanation;
    }


    /**
     * {@inheritdoc}
     *
     * Parent method result md5, here only need 9 digit of them.
     *      base_convert('f{8}', 16, 62) = cOu4kx
     *      base_convert('f{9}', 16, 62) = 3j1L7jb
     */
    protected function generateCustomPartAuto()
    {
        $seed = parent::generateCustomPartAuto();
        $seed = substr($seed, 0, 9);

        $converter = $this->getBaseConverter();
        $custom = $converter->convert($seed, 16, 62);

        // In case convert result not fulfill the length
        return $custom . '000000';
    }


    /**
     * {@inheritdoc}
     */
    protected function generateRandomPart()
    {
        $converter = $this->getBaseConverter();

        // base_convert('ZZZ', 62, 10) = 238327
        // base_convert('100', 62, 10) = 3844
        $randomPart = $converter->convert(mt_rand(3844, 238327), 10, 62) .
            $converter->convert(mt_rand(0, 238327), 10, 62);

        return $randomPart;
    }


    /**
     * {@inheritdoc}
     */
    protected function generateTimeParts()
    {
        list($microSecond, $second) = explode(' ', microtime());

        $converter = $this->getBaseConverter();

        $second = $converter->convert($second, 10, 62);

        $microSecond = round($microSecond * 1000000);
        $microSecond = $converter->convert($microSecond, 10, 62);
        $microSecond = str_pad(
            $microSecond,
            static::LENGTH_MICROSECOND,
            '0',
            STR_PAD_LEFT
        );

        return [$second, $microSecond];
    }
}
