<?php
/**
 * Explain given UUID
 *
 * @copyright   Copyright 2016 Fwolf
 * @license     http://opensource.org/licenses/MIT MIT
 */

use Fwolf\Util\Uuid\AbstractTimeBasedUuidGenerator;
use Fwolf\Util\Uuid\Base16WithCheckDigit;
use Fwolf\Util\Uuid\Base36;
use Fwolf\Util\Uuid\Base36Short;
use Fwolf\Util\Uuid\Base62;
use Fwolf\Util\Uuid\Base62Short;
use Fwolf\Util\Uuid\Explanation;

require __DIR__ . '/../vendor/autoload.php';

$showHelp = function () {
    $basename = basename(__FILE__);
    echo <<<EOF
Usage: $basename [UUID]


EOF;
};

if (2 > $argc) {
    $showHelp();
}

$uuid = $argv[1];
switch (strlen($uuid)) {
    case Base16WithCheckDigit::LENGTH:
        $className = Base16WithCheckDigit::class;
        break;

    case Base36::LENGTH:
        $className = Base36::class;
        break;

    case Base36Short::LENGTH:
        $className = Base36Short::class;
        break;

    case Base62::LENGTH:
        $className = Base62::class;
        break;

    case Base62Short::LENGTH:
        $className = Base62Short::class;
        break;

    default:
        echo 'Unknown UUID length' . PHP_EOL;
        exit;
}

$baseClassName = join('', array_slice(explode('\\', $className), -1));
echo "{$uuid} is {$baseClassName} UUID" . PHP_EOL;


/** @var AbstractTimeBasedUuidGenerator $generator */
$generator = new $className();
$explanation = $generator->explain($uuid);
$explanationAr = $explanation->toArray();

$explanationAr[Explanation::COL_VERIFIED] =
    $explanationAr[Explanation::COL_VERIFIED] ? 'true' : 'false';

foreach ($explanationAr as $key => $val) {
    $key = str_pad($key, 11, ' ', STR_PAD_LEFT);
    echo "  {$key}: {$val}" . PHP_EOL;
}
