<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID generator using base-36 characters (0-9a-z)
 *
 *
 * Second part: 6 chars, limit to 2038 by base36 timestamp:
 *      base_convert('zzzzzz', 36, 10) = 2176782335 = 2038-12-24 13:45:35
 *
 * Microsecond part: 4 chars, waste some number range (by * 1000000):
 *      base_convert(999999, 10, 36) = lflr
 *
 * So, For wider time range than 2038, we can start count timestamp from not
 * year 1970. And further, combine second and microsecond part together to use
 * its lflr~z{4} part. Result usable year raise to about 110 years. Detail:
 *
 *      If offset time is 2012-07-11 = 1341957600
 *      Lifetime start: (base36 of 10{6 + 4 - 1}) / 10^6 + offset timestamp =
 *          1443517557 = 2015-09-29 11:05:57
 *      Lifetime end: base36 of z{6 + 4} / 10^6 + offset timestamp =
 *          4998116040 = 2128-05-20 14:34:00
 *
 *
 * Group part: 2 chars
 *      base_convert('zz', 36, 10) = 1295, enough to group server.
 *
 *
 * Random part: 6 chars
 *      36^6 = 2176782336, about 50% of 16^8 = 4294967296,
 *      But microsecond is 200x of base16 UUID (10^6 vs 10^4 / 2).
 *
 *
 * @see         http://3v4l.org/YPTHo       Find best start date
 * @see         https://gist.github.com/fwolf/5f3e44343a3bebf36953
 * @see         http://3v4l.org/FMINm       Estimate lifetime
 * @see         https://gist.github.com/fwolf/b5b10173b00086d5f33c
 *
 *
 * @copyright   Copyright 2013-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base36 extends AbstractTimeBasedUuidGenerator
{
    /**
     * {@inheritdoc}
     */
    const LENGTH = 25;

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
    const LENGTH_CUSTOM = 7;

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
     * Start offset of timestamp
     */
    const TIMESTAMP_OFFSET = 1341957600;    // 2012-07-11


    /**
     * {@inheritdoc}
     */
    public function explain($uuid)
    {
        $explanation = parent::explain($uuid);

        $timeStr = $explanation->getSecond() . $explanation->getMicrosecond();
        $timeStr = base_convert($timeStr, 36, 10);

        $second = round($timeStr / 1000000) + static::TIMESTAMP_OFFSET;
        $second = date('Y-m-d H:i:s', $second);

        $microsecond = strval(round($timeStr % 1000000));

        $explanation->setSecond($second)
            ->setMicrosecond($microsecond);

        return $explanation;
    }


    /**
     * {@inheritdoc}
     *
     * Parent method result md5, here only need 10 digit of them.
     *      base_convert('z{7}', 36, 16) = 123ede3fff
     */
    protected function generateCustomPartAuto()
    {
        $seed = parent::generateCustomPartAuto();
        $seed = substr($seed, 0, 10);

        // In case convert result not fulfill the length
        return base_convert($seed, 16, 36) . '0000000';
    }


    /**
     * {@inheritdoc}
     */
    protected function generateRandomPart()
    {
        // base_convert('zzz', 36, 10) = 46655
        // base_convert('100', 36, 10) = 1296
        $randomPart = base_convert(mt_rand(1296, 46655), 10, 36) .
            base_convert(mt_rand(1296, 46655), 10, 36);

        return $randomPart;
    }


    /**
     * {@inheritdoc}
     */
    protected function generateTimeParts()
    {
        list($microSecond, $second) = explode(' ', microtime());

        $microSecond = round($microSecond * 1000000);
        $microSecond = str_pad($microSecond, 6, '0', STR_PAD_LEFT);

        $timestamp = $second - static::TIMESTAMP_OFFSET . $microSecond;
        $timeStr = base_convert($timestamp, 10, 36);

        return [
            substr($timeStr, 0, static::LENGTH_SECOND),
            substr($timeStr, static::LENGTH_SECOND, static::LENGTH_MICROSECOND),
        ];
    }
}
