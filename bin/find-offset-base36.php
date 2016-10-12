<?php
/**
 * Find latest timestamp offset for Base36 UUID
 *
 * Notice: Need 64-bit PHP environment for not overflow max integer
 *
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */

use Fwolf\Util\Uuid\Base36;

require __DIR__ . '/../vendor/autoload.php';

$eol = (PHP_SAPI == 'cli') ? PHP_EOL : '<br />' . PHP_EOL;

echo 'Find latest timestamp offset for Base36 UUID' . $eol . $eol;


// Factor of microsecond, which it multiple to convert to integer
$microFactor = 1000000;
$microFactorN = number_format($microFactor);


// Latest offset time
$length = Base36::LENGTH_SECOND + Base36::LENGTH_MICROSECOND;
$minTimestamp36 = '1' . str_repeat('0', $length - 1);
$minTimestamp36n = number_format($minTimestamp36);
echo "Second and microsecond part total {$length} digit in base36" . $eol;
echo "The minimal value is base36 {$minTimestamp36n}" . $eol;

$minTimestamp10 = base_convert($minTimestamp36, 36, 10);
echo "  base36 {$minTimestamp36n} = base10 {$minTimestamp10}" . $eol;

$minTimestamp10 = round($minTimestamp10 / $microFactor);
echo "  Remove microsecond part(divided by base10 {$microFactorN}), " .
    "second part is {$minTimestamp10}" . $eol;
echo "The minimal timestamp for second is {$minTimestamp10}" . $eol;

$nowTimestamp = time();
$nowDate = date('Y-m-d H:i:s', $nowTimestamp);
$startTimestamp = time() - $minTimestamp10;
$startDate = date('Y-m-d H:i:s', $startTimestamp);
echo "  Minus minimal timestamp with now timestamp:" . $eol;
echo "  $nowTimestamp ({$nowDate}) - $minTimestamp10 = " .
    "{$startTimestamp} ($startDate)" . $eol;
echo "Timestamp offset need set before {$startDate}" . $eol . $eol;


// Lifetime end time
$maxTimestamp36 = str_repeat('z', $length);
echo "The maximal time in base36 is {$maxTimestamp36}" . $eol;
$maxTimestamp10 = base_convert($maxTimestamp36, 36, 10);
echo "  base36 {$maxTimestamp36} = base10 {$maxTimestamp10}" . $eol;
$maxTimestamp10 = round($maxTimestamp10 / $microFactor);
echo "  Remove microsecond part(divided by base10 {$microFactorN}), " .
    "second part is {$maxTimestamp10}" . $eol;
$endTimestamp = $maxTimestamp10 + $startTimestamp;
$endDate = date('Y-m-d H:i:s', $endTimestamp);
echo "  Add start timestamp({$startTimestamp}), " .
    "got {$endTimestamp} ({$endDate})" . $eol;
echo "UUID lifetime end date is {$endDate}" . $eol . $eol;


echo "Short Version" . $eol;
echo "Latest timestamp offset: {$startDate} ($startTimestamp)" . $eol;
echo "     UUID can use up to: {$endDate}" . $eol;
