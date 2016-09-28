<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID explanation DTO
 *
 * Why not store UUID as an object contain several parts as properties ?
 *  - UUID generator need speed
 *  - UUID explain is not widely needed
 *
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Explanation
{
    /**
     * Array key for explain result
     */
    const COL_SECOND = 'second';

    const COL_MICROSECOND = 'microSecond';

    const COL_GROUP = 'group';

    const COL_CUSTOM = 'custom';

    const COL_RANDOM = 'random';

    const COL_CHECK_DIGIT = 'checkDigit';

    /**
     * Is verify success
     */
    const COL_VERIFIED = 'verified';

    /**
     * @var string
     */
    protected $checkDigit = '';

    /**
     * @var string
     */
    protected $custom = '';

    /**
     * @var string
     */
    protected $group = '';

    /**
     * @var string
     */
    protected $microsecond = '';

    /**
     * @var string
     */
    protected $random = '';

    /**
     * @var string
     */
    protected $second = '';

    /**
     * @var bool
     */
    protected $verified = true;


    /**
     * @return  string
     */
    public function getCheckDigit()
    {
        return $this->checkDigit;
    }


    /**
     * @return  string
     */
    public function getCustom()
    {
        return $this->custom;
    }


    /**
     * @return  string
     */
    public function getGroup()
    {
        return $this->group;
    }


    /**
     * @return  string
     */
    public function getMicrosecond()
    {
        return $this->microsecond;
    }


    /**
     * @return  string
     */
    public function getRandom()
    {
        return $this->random;
    }


    /**
     * @return  string
     */
    public function getSecond()
    {
        return $this->second;
    }


    /**
     * @return  boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }


    /**
     * @param   string $checkDigit
     * @return  $this
     */
    public function setCheckDigit($checkDigit)
    {
        $this->checkDigit = $checkDigit;

        return $this;
    }


    /**
     * @param   string $custom
     * @return  $this
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }


    /**
     * @param   string $group
     * @return  $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }


    /**
     * @param   string $microsecond
     * @return  $this
     */
    public function setMicrosecond($microsecond)
    {
        $this->microsecond = $microsecond;

        return $this;
    }


    /**
     * @param   string $random
     * @return  $this
     */
    public function setRandom($random)
    {
        $this->random = $random;

        return $this;
    }


    /**
     * @param   string $second
     * @return  $this
     */
    public function setSecond($second)
    {
        $this->second = $second;

        return $this;
    }


    /**
     * @param   boolean $verified
     * @return  $this
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }


    /**
     * @return  array
     */
    public function toArray()
    {
        return [
            static::COL_SECOND      => $this->getSecond(),
            static::COL_MICROSECOND => $this->getMicrosecond(),
            static::COL_GROUP       => $this->getGroup(),
            static::COL_CUSTOM      => $this->getCustom(),
            static::COL_RANDOM      => $this->getRandom(),
            static::COL_CHECK_DIGIT => $this->getCheckDigit(),
            static::COL_VERIFIED    => $this->isVerified(),
        ];
    }
}
