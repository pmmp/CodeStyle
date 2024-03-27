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

use PhpCsFixer\Tokenizer\Tokens;
use function defined;
use const T_CATCH;
use const T_DECLARE;
use const T_DO;
use const T_ELSE;
use const T_ELSEIF;
use const T_FINALLY;
use const T_FOR;
use const T_FOREACH;
use const T_IF;
use const T_MATCH;
use const T_SWITCH;
use const T_TRY;
use const T_WHILE;

trait Common{

	private function findParenthesisEnd(Tokens $tokens, int $structureTokenIndex) : int{
		$nextIndex = $tokens->getNextMeaningfulToken($structureTokenIndex);
		if($nextIndex === null){
			return $structureTokenIndex;
		}
		$nextToken = $tokens[$nextIndex];

		// return if next token is not opening parenthesis
		if(!$nextToken->equals('(')){
			return $structureTokenIndex;
		}

		return $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $nextIndex);
	}

	/**
	 * @return int[]
	 */
	private function getControlStructure() : array{
		$controlStructureTokens = [T_DECLARE, T_DO, T_ELSE, T_ELSEIF, T_FINALLY, T_FOR, T_FOREACH, T_IF, T_WHILE, T_TRY, T_CATCH, T_SWITCH];
		// @TODO: drop condition when PHP 8.0+ is required
		if(defined('T_MATCH')){
			$controlStructureTokens[] = T_MATCH;
		}

		return $controlStructureTokens;
	}
}
