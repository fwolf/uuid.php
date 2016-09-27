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
 * @copyright   Copyright 2015-2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */
interface GeneratorInterface
{
    /**
     * Explain each part of an UUID
     *
     * @param   string $uuid
     * @return  array
     */
    public function explain($uuid);


    /**
     * Generate an UUID
     *
     * Normally group 0 should reserve for develop/test environment.
     *
     * @param   int|string $groupId
     * @param   string     $custom
     * @return  string
     */
    public function generate($groupId = '1', $custom = '');


    /**
     * Verify if an UUID is valid
     *
     * @param   string $uuid
     * @return  boolean
     */
    public function verify($uuid);
}
