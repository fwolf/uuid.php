<?php
namespace Fwolf\Util\Uuid;

/**
 * Common define and function of UUID generators
 *
 * Length and separator are default configured for Base16, but they should be
 * re-defined in child class.
 *
 * If check digit length is not zero, its enabled.
 *
 * @copyright   Copyright 2008-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
abstract class AbstractTimeBasedUuidGenerator implements GeneratorInterface
{
    /**
     * Name of class to store explanation information
     */
    const EXPLANATION_CLASS = Explanation::class;

    /**
     * Total UUID length
     */
    const LENGTH = 36;

    /**
     * Length of second part
     */
    const LENGTH_SECOND = 8;

    /**
     * Length of microsecond part
     */
    const LENGTH_MICROSECOND = 4;

    /**
     * Length of group part
     */
    const LENGTH_GROUP = 4;

    /**
     * Length of custom part
     */
    const LENGTH_CUSTOM = 4;

    /**
     * Length of random part
     */
    const LENGTH_RANDOM = 12;

    /**
     * How many chars check digit use, zero to disable it
     *
     * Longer can avoid duplicate but consume more length of random part.
     */
    const LENGTH_CHECK_DIGIT = 0;

    /**
     * Separator chars between UUID parts
     */
    const SEPARATOR = '-';


    /**
     * Add check digit to an UUID
     *
     * Check digit will be add by replace chars from tail of UUID.
     *
     * Check digit should not include separator in common case.
     *
     * @param   string $uuid
     * @return  string
     */
    protected function addCheckDigit($uuid)
    {
        $headPartLength = static::LENGTH - static::LENGTH_CHECK_DIGIT;
        $headPart = substr($uuid, 0, $headPartLength);

        $checkDigit = $this->computeCheckDigit($headPart);

        return $headPart . $checkDigit;
    }


    /**
     * Compute check digit by given head part of UUID
     *
     * @param   string $headPart
     * @return  string
     */
    protected function computeCheckDigit($headPart)
    {
        // Use md5 which result only 0-0 a-f to fit all UUID mode
        $checkDigit = substr(md5($headPart), 0, static::LENGTH_CHECK_DIGIT);

        return $checkDigit;
    }


    /**
     * {@inheritdoc}
     */
    public function explain($uuid)
    {
        // Time is various by UUID mode, so meaning of time parts remain
        // to child class to explain.
        $second = substr($uuid, 0, static::LENGTH_SECOND);
        $position = static::LENGTH_SECOND + strlen(static::SEPARATOR);

        $microSecond = substr($uuid, $position, static::LENGTH_MICROSECOND);
        $position += static::LENGTH_MICROSECOND + strlen(static::SEPARATOR);

        $group = substr($uuid, $position, static::LENGTH_GROUP);
        $position += static::LENGTH_GROUP + strlen(static::SEPARATOR);

        $custom = substr($uuid, $position, static::LENGTH_CUSTOM);
        $position += static::LENGTH_CUSTOM + strlen(static::SEPARATOR);

        $random = substr($uuid, $position, static::LENGTH_RANDOM);

        if (0 != static::LENGTH_CHECK_DIGIT) {
            $checkDigit = substr($random, -1 * static::LENGTH_CHECK_DIGIT);
            $random = substr(
                $random,
                0,
                static::LENGTH_RANDOM - static::LENGTH_CHECK_DIGIT
            );
        } else {
            $checkDigit = '';
        }

        $verified = $this->verify($uuid);


        $className = static::EXPLANATION_CLASS;
        /** @var Explanation $explanation */
        $explanation = (new $className);

        $explanation->setSecond($second)
            ->setMicrosecond($microSecond)
            ->setGroup($group)
            ->setCustom($custom)
            ->setRandom($random)
            ->setCheckDigit($checkDigit)
            ->setVerified($verified);

        return $explanation;
    }


    /**
     * {@inheritdoc}
     */
    public function generate($groupId = '1', $custom = '')
    {
        $parts = array_merge($this->generateTimeParts(), [
            $this->generateGroupPart($groupId),
            $this->generateCustomPart($custom),
            $this->generateRandomPart(),
        ]);
        $uuid = implode(static::SEPARATOR, $parts);

        if (0 != static::LENGTH_CHECK_DIGIT) {
            $uuid = $this->addCheckDigit($uuid);
        }

        return $uuid;
    }


    /**
     * @param   string $custom
     * @return  string
     */
    protected function generateCustomPart($custom = '')
    {
        $scriptName = strval(filter_input(INPUT_SERVER, 'SCRIPT_NAME'));
        $scriptName = md5(strval($scriptName));

        $customPart = substr($custom . $scriptName, 0, static::LENGTH_CUSTOM);

        return $customPart;
    }


    /**
     * @param   string $groupId
     * @return  string
     */
    protected function generateGroupPart($groupId)
    {
        $groupPart = substr(
            str_repeat('0', static::LENGTH_GROUP) . $groupId,
            -1 * static::LENGTH_GROUP
        );

        return $groupPart;
    }


    /**
     * @return  string
     */
    protected function generateRandomPart()
    {
        $randomPart = substr(md5(uniqid('', true)), 0, static::LENGTH_RANDOM);

        return $randomPart;
    }


    /**
     * @return  array
     */
    protected function generateTimeParts()
    {
        list($microSecond, $second) = explode(' ', microtime());

        // 8 chars timestamp second, hex mode
        // 2030-12-31 = 1924876800 = 0x72bb4a00
        // 0xffffff = 4294967295 = 2106-02-07 14:28:15
        $len = static::LENGTH_SECOND;
        $second = substr(
            str_repeat('0', $len) . base_convert($second, 10, 16),
            -1 * $len
        );

        // 4 chars from left-side start of current microsecond
        // 0xffff = 65535
        // To make value fit range, * 100000 and div by 2(max 50000)
        $len = static::LENGTH_MICROSECOND;
        $microSecond = substr(
            str_repeat('0', $len) .
            base_convert(round($microSecond * 100000 / 2), 10, 16),
            -1 * $len
        );

        return [$second, $microSecond];
    }


    /**
     * {@inheritdoc}
     *
     * Without checkDigit, UUID can only verified by a few constraint like
     * compare its length with definition.
     *
     * With checkDigit, UUID can be verified by re-compute check digits.
     */
    public function verify($uuid)
    {
        // Length check
        if (static::LENGTH != strlen($uuid)) {
            return false;
        }

        // Check digit
        if (0 != static::LENGTH_CHECK_DIGIT &&
            $uuid != $this->addCheckDigit($uuid)
        ) {
            return false;
        }

        return true;
    }
}
