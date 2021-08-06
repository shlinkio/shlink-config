<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\Config\Collection;

use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Config\Collection\PathCollection;

class PathCollectionTest extends TestCase
{
    private const INITIAL_ARRAY = [
        'foo' => [
            'bar' => [
                'baz' => 'Hello world!',
            ],
            'other' => 123,
        ],
        'something' => [],
        'another' => [
            'one' => 'Shlink',
        ],
    ];

    private PathCollection $collection;

    public function setUp(): void
    {
        $this->collection = new PathCollection(self::INITIAL_ARRAY);
    }

    /**
     * @test
     * @dataProvider providePaths
     */
    public function pathExistsReturnsExpectedValue(array $path, bool $expected): void
    {
        self::assertEquals($expected, $this->collection->pathExists($path));
    }

    public function providePaths(): iterable
    {
        yield [[], false];
        yield [['boo'], false];
        yield [['foo', 'nop'], false];
        yield [['another', 'one', 'nop'], false];
        yield [['foo'], true];
        yield [['foo', 'bar'], true];
        yield [['foo', 'bar', 'baz'], true];
        yield [['something'], true];
    }

    /**
     * @test
     * @dataProvider providePathsWithValue
     */
    public function getValueInPathReturnsExpectedValue(array $path, mixed $expected): void
    {
        self::assertEquals($expected, $this->collection->getValueInPath($path));
    }

    public function providePathsWithValue(): iterable
    {
        yield [[], null];
        yield [['boo'], null];
        yield [['foo', 'nop'], null];
        yield [['another', 'one', 'nop'], null];
        yield [['foo'], [
            'bar' => [
                'baz' => 'Hello world!',
            ],
            'other' => 123,
        ]];
        yield [['foo', 'bar'], [
            'baz' => 'Hello world!',
        ]];
        yield [['foo', 'bar', 'baz'], 'Hello world!'];
        yield [['something'], []];
    }

    /**
     * @test
     * @dataProvider providePathsToUnset
     */
    public function unsetPathHasExpectedResult(array $path, array $expectedResult): void
    {
        $this->collection->unsetPath($path);
        self::assertEquals($expectedResult, $this->collection->toArray());
    }

    public function providePathsToUnset(): iterable
    {
        yield [['bar', 'foo'], self::INITIAL_ARRAY];
        yield [['foo', 'bar'], [
            'foo' => [
                'other' => 123,
            ],
            'something' => [],
            'another' => [
                'one' => 'Shlink',
            ],
        ]];
        yield [['foo', 'bar', 'baz'], [
            'foo' => [
                'other' => 123,
            ],
            'something' => [],
            'another' => [
                'one' => 'Shlink',
            ],
        ]];
        yield [['something'], [
            'foo' => [
                'bar' => [
                    'baz' => 'Hello world!',
                ],
                'other' => 123,
            ],
            'another' => [
                'one' => 'Shlink',
            ],
        ]];
        yield [['foo', 'other'], [
            'foo' => [
                'bar' => [
                    'baz' => 'Hello world!',
                ],
            ],
            'something' => [],
            'another' => [
                'one' => 'Shlink',
            ],
        ]];
        yield [['another', 'one'], [
            'foo' => [
                'bar' => [
                    'baz' => 'Hello world!',
                ],
                'other' => 123,
            ],
            'something' => [],
        ]];
    }
}
