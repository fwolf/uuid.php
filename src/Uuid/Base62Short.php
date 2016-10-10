<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID generator using base-62 character, short version
 *
 *
 * second: 5 chars
 * microsecond: 4 chars, waste some number range (by * 1000000):
 *      base_convert(999,999, 10, 62) = 4c91
 *
 * So, For wider time range, we can start count timestamp from not
 * year 1970. And combine second and microsecond part together before
 * convert to base62. Result usable year raise to about 420 years. Detail:
 *
 *      If offset time is 2009-10-10 = 1255104000
 *      Lifetime start: (base62 of 10{5 + 4 - 1}) / 10^6 + offset timestamp =
 *          1473444105 = 2016-09-10 02:01:45
 *      Lifetime end: base62 of Z{5 + 4} / 10^6 + offset timestamp =
 *          14792190546 = 2438-09-30 05:49:06
 *
 *      Why 2009-10-10?
 *      Base62 10{5 + 4 - 1} / base10 10^6 = 218340105 = 1976-12-02 10:01:45
 *      Means it need to be 6-12-02 10:01:45 from start timestamp
 *      Now(2016-10-10) - 6-12-02 10:01:45 = about 2009-10-10
 *
 *
 * random: 5 chars
 *      62^5 = 916132831, about 1/5 of 16^8 = 4294967296,
 *      but microsecond is 100x of general UUID.
 *
 *
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base62Short extends Base62
{
    /**
     * {@inheritdoc}
     */
    const LENGTH = 15;

    /**
     * {@inheritdoc}
     */
    const LENGTH_SECOND = 5;

    /**
     * {@inheritdoc}
     */
    const LENGTH_MICROSECOND = 4;

    /**
     * {@inheritdoc}
     */
    const LENGTH_GROUP = 1;

    /**
     * {@inheritdoc}
     */
    const LENGTH_CUSTOM = 0;

    /**
     * {@inheritdoc}
     */
    const LENGTH_RANDOM = 5;

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
    const TIMESTAMP_OFFSET = 1255104000;    // 2009-10-10


    /**
     * {@inheritdoc}
     */
    public function explain($uuid)
    {
        $explanation = parent::explain($uuid);

        $converter = $this->getBaseConverter();

        // Parent class Base62 explain time parts different, so get raw again
        $second = substr($uuid, 0, static::LENGTH_SECOND);
        $position = static::LENGTH_SECOND + strlen(static::SEPARATOR);
        $microSecond = substr($uuid, $position, static::LENGTH_MICROSECOND);

        $timeStr = $second . $microSecond;
        $timeStr = $converter->convert($timeStr, 62, 10);

        $second = round($timeStr / 1000000) + static::TIMESTAMP_OFFSET;
        $second = date('Y-m-d H:i:s', $second);

        $microsecond = strval(round($timeStr % 1000000));

        $explanation->setSecond($second)
            ->setMicrosecond($microsecond);

        return $explanation;
    }


    /**
     * {@inheritdoc}
     */
    protected function generateRandomPart()
    {
        $random = parent::generateRandomPart();

        $random = substr($random, 0, static::LENGTH_RANDOM);

        return $random;
    }


    /**
     * {@inheritdoc}
     */
    protected function generateTimeParts()
    {
        list($microSecond, $second) = explode(' ', microtime());

        $microSecond = round($microSecond * 1000000);
        $microSecond = str_pad($microSecond, 6, '0', STR_PAD_LEFT);

        $converter = $this->getBaseConverter();

        $timestamp = strval($second - static::TIMESTAMP_OFFSET) . $microSecond;
        $timeStr = $converter->convert($timestamp, 10, 62);

        return [
            substr($timeStr, 0, static::LENGTH_SECOND),
            substr($timeStr, static::LENGTH_SECOND, static::LENGTH_MICROSECOND),
        ];
    }
}
