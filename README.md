# Time Based UUID Generator


[![Travis](https://travis-ci.org/fwolf/uuid.php.svg?branch=master)](https://travis-ci.org/fwolf/uuid.php)
[![Latest Stable Version](https://poser.pugx.org/fwolf/uuid/v/stable)](https://packagist.org/packages/fwolf/uuid)
[![License](https://poser.pugx.org/fwolf/uuid/license)](https://packagist.org/packages/fwolf/uuid)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0b69a67a-56ee-4124-a8bb-5ecab610759d/mini.png)](https://insight.sensiolabs.com/projects/0b69a67a-56ee-4124-a8bb-5ecab610759d)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fwolf/uuid.php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fwolf/uuid.php/?branch=master)


Generate time based UUID, with custom format and length.

UUIDs follow alphabetical order, more suitable for database primary key.

Short UUID save more space, and little more eye candy.

Check digit can determine if an UUID is valid, maybe useful.


## Install

    composer require fwolf/uuid:~1.0


## UUID Types

|         Name         |                  FQN                 | Length |                Example               |
|:--------------------:|:------------------------------------:|:------:|:------------------------------------:|
| Base16               | Fwolf\Util\Uuid\Base16               |   36   | 57fbbc3d-afca-0001-5962-39f13698e4fe |
| Base16WithCheckDigit | Fwolf\Util\Uuid\Base16WithCheckDigit |   36   | 57fbbc3d-afd6-0001-5962-66ede233d441 |
| Base36               | Fwolf\Util\Uuid\Base36               |   25   | 1bjzaogobg01b0tjd6q2qx6t9            |
| Base36Short          | Fwolf\Util\Uuid\Base36Short          |   16   | 1bjzaogok11ggcm5                     |
| Base62               | Fwolf\Util\Uuid\Base62               |   24   | 1BTD4N3MsO01qbPidY17hfOz             |
| Base62Short          | Fwolf\Util\Uuid\Base62Short          |   15   | 10L1XTQ9s1Ip2Og                      |

By inherit these classes and modify constant value, you can:

- Define length of each part
- Enable check digit
- Change of enable/disable separator between parts


## Usage

```php
use Fwolf\Util\Uuid\Base36;

$generator = new Base36();

$uuid = $generator->generate();
echo "Generated UUID: {$uuid}";
// Result: Generated UUID: 1bjzaogobg01b0tjd6q2qx6t9
```


## License

Distribute under MIT License.
