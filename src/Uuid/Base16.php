<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID like common format
 *
 * Old UUID format:
 *
 * [timeLow]-[timeMid]-[custom1]-[custom2](part1/2)
 *  -[custom2](part2/2)[random1][random2]
 *
 * timeLow: 8 chars, seconds in microtime, hex format.
 * timeMid: 4 chars, micro-second in microtime, plus 10000, hex format.
 * custom1: 4 chars, user defined, '0000' if empty, hex format suggested.
 * custom2: 8 chars, user defined, hex of user ip if empty,
 *          and random hex string if user ip cannot get, hex format too.
 * random1: 4 chars, random string, hex format.
 * random2: 4 chars, random string, hex format.
 *
 * New UUID format move custom2(part2) to random part, parts are splitted
 * separator.
 *
 * @see         http://us.php.net/uniqid
 *
 * @copyright   Copyright 2008-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base16 extends AbstractTimeBasedUuidGenerator
{
    /**
     * {@inheritdoc}
     */
    const LENGTH = 36;

    /**
     * {@inheritdoc}
     */
    const LENGTH_SECOND = 8;

    /**
     * {@inheritdoc}
     */
    const LENGTH_MICROSECOND = 4;

    /**
     * {@inheritdoc}
     */
    const LENGTH_GROUP = 4;

    /**
     * {@inheritdoc}
     */
    const LENGTH_CUSTOM = 4;

    /**
     * {@inheritdoc}
     */
    const LENGTH_RANDOM = 12;

    /**
     * {@inheritdoc}
     */
    const LENGTH_CHECK_DIGIT = 0;

    /**
     * {@inheritdoc}
     */
    const SEPARATOR = '-';


    /**
     * {@inheritdoc}
     */
    public function explain($uuid)
    {
        $infoAr = parent::explain($uuid);

        $second = $infoAr[static::COL_SECOND];
        $second = base_convert($second, 16, 10);
        $infoAr[static::COL_SECOND] = date('Y-m-d H:i:s', $second);

        $infoAr[static::COL_MICROSECOND] =
            base_convert($infoAr[static::COL_MICROSECOND], 16, 10) * 2;

        return $infoAr;
    }
}
