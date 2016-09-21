<?php
namespace Fwolf\Util\Uuid;

/**
 * UUID generator
 *
 * UUID are combine of several parts:
 *
 * [second][microsecond][group][custom][random]
 *
 * Length of each part, separator are different by algorithms.
 *
 * Check digit is default off for speedup.
 *
 * @copyright   Copyright 2015-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
interface GeneratorInterface
{
    /**
     * Explain each part of an UUID
     *
     * @param   string  $uuid
     * @param   boolean $withCheckDigit Source includes check digit
     * @return  array
     */
    public function explain($uuid, $withCheckDigit = false);


    /**
     * Generate an UUID
     *
     * If $checkDigit is true, use last byte or bytes as check digits.
     *
     * Normally group below 10(what ever base) should reserve for develop/test
     * environment.
     *
     * @param   int|string $groupId
     * @param   string     $custom
     * @param   boolean    $checkDigit
     * @return  string
     */
    public function generate(
        $groupId = '1',
        $custom = '',
        $checkDigit = false
    );


    /**
     * Verify if an UUID is valid
     *
     * Without checkDigit, UUID can only verified by a few constraint like
     * compare its length with definition.
     *
     * With checkDigit, UUID can be verified by re-compute check digits.
     *
     * @param   string  $uuid
     * @param   boolean $withCheckDigit Source include check digits
     * @return  boolean
     */
    public function verify($uuid, $withCheckDigit = false);
}
