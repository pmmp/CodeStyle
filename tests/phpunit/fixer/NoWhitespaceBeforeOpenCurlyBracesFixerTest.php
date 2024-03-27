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

namespace pocketmine\codestyle\tests\phpunit\fixer;

use PHPUnit\Framework\Attributes\DataProvider;

class NoWhitespaceBeforeOpenCurlyBracesFixerTest extends AbstractFixerTestCase{
	#[DataProvider('provideFixCases')]
	public function testFix(string $expected, ?string $input = null) : void{
		$this->doTest($expected, $input);
	}

	/**
	 * @return iterable<array{string, string}>
	 */
	public static function provideFixCases() : iterable{
		yield 'if (same line without extra space)' => [
			'<?php
                if ($foo){
                    foo();
                }',
			'<?php
                if ($foo) {
                    foo();
                }',
		];
		yield 'else (same line without extra space)' => [
			'<?php
                if ($foo){
                    foo();
                }
                else{
                    bar();
                }',
			'<?php
                if ($foo) {
                    foo();
                }
                else {
                    bar();
                }',
		];
		yield 'elseif (same line without extra space)' => [
			'<?php
                if ($foo){
                    foo();
                }
                elseif ($bar){
                    bar();
                }',
			'<?php
                if ($foo) {
                    foo();
                }
                elseif ($bar) {
                    bar();
                }',
		];
		yield 'else if (same line without extra space)' => [
			'<?php
                if ($foo){
                    foo();
                }
                elseif ($bar){
                    bar();
                }',
			'<?php
                if ($foo) {
                    foo();
                }
                elseif ($bar) {
                    bar();
                }',
		];
		yield 'for (same line without extra space)' => [
			'<?php
                for (;;){
                    foo();
                }',
			'<?php
                for (;;) {
                    foo();
                }',
		];
		yield 'foreach (same line without extra space)' => [
			'<?php
                foreach ($foo as $bar){
                    foo();
                }',
			'<?php
                foreach ($foo as $bar) {
                    foo();
                }',
		];
		yield 'do while (same line without extra space)' => [
			'<?php
                do{
                    foo();
                } while ($foo);',
			'<?php
                do {
                    foo();
                } while ($foo);',
		];
		yield 'switch (same line without extra space)' => [
			'<?php
                switch ($foo){
                    case 1:
                        foo();
                }',
			'<?php
                switch ($foo) {
                    case 1:
                        foo();
                }',
		];
		yield 'class (same line without extra space)' => [
			'<?php
                class Foo{
                }',
			'<?php
                class Foo
                {
                }',
		];
		yield 'function (same line without extra space)' => [
			'<?php
                function foo(){
                }',
			'<?php
                function foo()
                {
                }',
		];
		yield 'anonymous function (same line without extra space)' => [
			'<?php
                $foo = function (){
                };',
			'<?php
                $foo = function () {
                };',
		];
		yield 'same line without extra space with newline before closing parenthesis' => [
			'<?php
                if ($foo
                ){
                    foo();
                }',
			'<?php
                if ($foo
                )
                {
                    foo();
                }',
		];
		yield 'same line without extra space with newline in signature but not before closing parenthesis' => [
			'<?php
                if (
                    $foo){
                    foo();
                }',
			'<?php
                if (
                    $foo) {
                    foo();
                }',
		];
		yield 'anonymous class (same line without extra space)' => [
			'<?php
                $foo = new class(){
                };',
			'<?php
                $foo = new class() {
                };',
		];
		yield 'same line without extra space with multiline signature and return type' => [
			'<?php
                function foo(
                    $foo
                ): int{
                    foo();
                }',
			'<?php
                function foo(
                    $foo
                ): int
                {
                    foo();
                }',
		];
		yield 'same line without extra space with multiline signature and return type (nullable)' => [
			'<?php
                function foo(
                    $foo
                ): ?int{
                    foo();
                }',
			'<?php
                function foo(
                    $foo
                ): ?int
                {
                    foo();
                }',
		];
		yield 'same line without extra space with multiline signature and return type (array)' => [
			'<?php
                function foo(
                    $foo
                ): array{
                    foo();
                }',
			'<?php
                function foo(
                    $foo
                ): array
                {
                    foo();
                }',
		];
		yield 'same line without extra space with with multiline signature and return type (class name)' => [
			'<?php
                function foo(
                    $foo
                ): \Foo\Bar{
                    foo();
                }',
			'<?php
                function foo(
                    $foo
                ): \Foo\Bar
                {
                    foo();
                }',
		];
		yield 'same line without extra space with newline before closing parenthesis and return type' => [
			'<?php
                function foo($foo
                ): int{
                    foo();
                }',
			'<?php
                function foo($foo
                ): int
                {
                    foo();
                }',
		];
		yield 'same line without extra space with newline before closing parenthesis and callable type' => [
			'<?php
                function foo($foo
                ): callable{
                    return function (): void{};
                }',
			'<?php
                function foo($foo
                ): callable
                {
                    return function (): void {};
                }',
		];
		yield 'same line without extra space with newline in signature but not before closing parenthesis and return type' => [
			'<?php
                function foo(
                    $foo): int{
                    foo();
                }',
			'<?php
                function foo(
                    $foo): int {
                    foo();
                }',
		];
		yield 'multiple elseifs (same line without extra space)' => [
			'<?php if ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                } elseif ($foo){
                }',
			'<?php if ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                } elseif ($foo) {
                }',
		];
	}
}
