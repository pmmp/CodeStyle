# Pocketmine code style custom rules

This repository contains Pocketmine's style rules, including custom rules.

## Installation

Install the package via composer:

```bash
composer require --global friendsofphp/php-cs-fixer

composer require --dev pocketmine/codestyle
```

## Usage

Create a `.php-cs-fixer.php` file in the root of your project with the following content:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use pocketmine\codestyle\PocketmineConfig;

$finder = PhpCsFixer\Finder::create()
	->in(__DIR__ . '/src'); // change this to the path of your source code

return (new PocketmineConfig($finder));
```