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

use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use const T_FUNCTION;

class NoWhitespaceBeforeOpenCurlyBracesFixer extends AbstractFixer{
	use Common;

	public function getDefinition() : FixerDefinitionInterface{
		return new FixerDefinition(
			"There must be no extra whitespace before open curly braces",
			[
				new CodeSample('<?php
if (true){
}
'),
			],
			"",
		);
	}

	public function isCandidate(Tokens $tokens) : bool{
		return $tokens->isTokenKindFound('{');
	}

	public function getPriority() : int{
		return 1; // Must run after CurlyBracesPositionFixer
	}

	public function isRisky() : bool{
		return false;
	}

	public function fix(\SplFileInfo $file, Tokens $tokens) : void{
		$classyTokens = Token::getClassyTokenKinds();
		$controlStructureTokens = $this->getControlStructure();

		foreach($tokens as $index => $token){
			if($token === null){
				continue;
			}

			if($token->isGivenKind($classyTokens)){
				$openBraceIndex = $tokens->getNextTokenOfKind($index, ['{']);
			} elseif($token->isGivenKind(T_FUNCTION)){
				$openBraceIndex = $tokens->getNextTokenOfKind($index, ['{', ';']);
			} elseif($token->isGivenKind($controlStructureTokens)){
				$parenthesisEndIndex = $this->findParenthesisEnd($tokens, $index);
				$openBraceIndex = $tokens->getNextMeaningfulToken($parenthesisEndIndex);
			} else{
				continue;
			}

			if($openBraceIndex === null){
				continue;
			}

			$tokens->removeLeadingWhitespace($openBraceIndex);
		}
	}
}
