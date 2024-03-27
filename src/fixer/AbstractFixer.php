<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\codestyle\fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Preg;
use function str_replace;
use function strtolower;
use function substr;

abstract class AbstractFixer implements FixerInterface{
	final public static function name() : string{
		$name = Preg::replace('/(?<!^)(?=[A-Z])/', '_', substr(
			str_replace(__NAMESPACE__, "", static::class)
			, 1, -5));

		return 'Pocketmine/' . strtolower($name);
	}

	final public function getName() : string{
		return self::name();
	}

	final public function supports(\SplFileInfo $file) : bool{
		return true;
	}
}
