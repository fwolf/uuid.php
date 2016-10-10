<?php
/**
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */

use Fwolf\Util\Uuid\Base16;
use Fwolf\Util\Uuid\Base16WithCheckDigit;
use Fwolf\Util\Uuid\Base36;
use Fwolf\Util\Uuid\Base36Short;
use Fwolf\Util\Uuid\Base62;
use Fwolf\Util\Uuid\Base62Short;

require __DIR__ . '/../vendor/autoload.php';

$eol = (PHP_SAPI == 'cli') ? PHP_EOL : '<br />' . PHP_EOL;

$base16 = new Base16();
$uuid = $base16->generate();
echo "Base16                 : {$uuid}{$eol}";

$base16Checked = new Base16WithCheckDigit();
$uuid = $base16Checked->generate();
echo "Base16 with check digit: {$uuid}{$eol}";

$base36 = new Base36();
$uuid = $base36->generate();
echo "Base36                 : {$uuid}{$eol}";

$base36Short = new Base36Short();
$uuid = $base36Short->generate();
echo "Base36 short version   : {$uuid}{$eol}";

$base62 = new Base62();
$uuid = $base62->generate();
echo "Base62                 : {$uuid}{$eol}";

$base62Short = new Base62Short();
$uuid = $base62Short->generate();
echo "Base62 short version   : {$uuid}{$eol}";
