# Opening Hours Component

[![Downloads this Month](https://img.shields.io/packagist/dm/cothema/opening-hours.svg)](https://packagist.org/packages/cothema/opening-hours)
[![Latest stable](https://img.shields.io/packagist/v/cothema/opening-hours.svg)](https://packagist.org/packages/cothema/opening-hours)

## Installation

Install cothema/opening-hours using  [Composer](http://getcomposer.org/):

```sh
$ composer require cothema/opening-hours
```

## Example Usage

```php
use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Status;
use Nette\Utils\DateTime;

$openingHours = new OpeningHours;
$openingHours->setOpeningHours([
    '0' => ['10:00', '20:00'], // Sunday
    '1' => ['22:00', '02:00 +1 day'], // Monday
    '2' => ['08:00', '24:00'], // Tuesday
    '3' => ['08:00', '20:00'], // Wednesday
    '4' => ['10:00', '20:00'], // Thursday
    '5' => ['00:00', '20:00'], // Friday
    '6' => ['01:00', '24:00'] // Saturday
]);

$openingHours->addSpecificDay('2015-11-15', ['12:00', '16:00']);
$openingHours->addSpecificDays(['2015-11-20', '2015-11-25'], ['10:00', '01:00 +1 day']);
$openingHours->addSpecificDays(['2015-12-01', '2015-12-02'], FALSE); // Closed all the day

$status = new Status($openingHours);
$status->setTime(new DateTime('2015-11-30 12:00:00')); // Monday
$status->isOpened(); // returns FALSE
```
