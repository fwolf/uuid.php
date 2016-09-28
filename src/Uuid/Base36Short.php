<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID generator using base-36 character, short version
 *
 * {@see Base36} algorithm is good, but the uuid is still too long. For small
 * scale system, we may need this short version.
 *
 * The second and microsecond part remain same length and algorithm, to keep
 * maximum usage of PHP microtime precision, so the lifetime and timestamp
 * offset are also same.
 *
 * As a small scale, we reduce:
 *  - length of group from 2 to 1, maximum 36 servers
 *  - length of custom from 7 to 0
 *  - length of random from 6 to 5
 *
 * Random part need to ensure no duplicate in 0.000001 second, we use decimal
 * part of {@see uniqid()} with more_entropy enabled. as its integer part is
 * generated base on microtime. We got a 8 digit number, enough to avoid dup in
 * 1 microsecond. The largest number 99,999,999 in base36 is '1n.chr' cost 6
 * bytes, so we divide it by 2 to use 5 bytes storage, should be enough too.
 *
 * Length of UUID is 16 bytes, no separator.
 *
 *
 * For safe speed in 1 microsecond (not millisecond), reference:
 *
 * @see         http://github.com/mumrah/flake-java   1k / millisecond = 1/ms
 * @see         https://github.com/twitter/snowflake/tree/snowflake-2010
 *              0.5/ms
 *
 *
 * @copyright   Copyright 2015-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Base36Short extends Base36
{
    /**
     * {@inheritdoc}
     */
    const LENGTH = 16;

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
     * {@inheritdoc}
     */
    protected function generateRandomPart()
    {
        $decimalPart = substr(uniqid('', true), -8);

        $decimalPart = round($decimalPart / 2);

        $encoded = base_convert($decimalPart, 10, 36);

        $random = str_pad($encoded, static::LENGTH_RANDOM, '0', STR_PAD_LEFT);

        return $random;
    }
}
