<?php

namespace DivineOmega\CamelCaser\Tests\Alias;

use DivineOmega\CamelCaser\Alias\AliasInterface;
use DivineOmega\CamelCaser\Alias\AliasIterator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DivineOmega\CamelCaser\Alias\AliasIterator
 */
class AliasIteratorTest extends TestCase
{
    /**
     * @dataProvider aliasProvider
     *
     * @param AliasInterface ...$aliases
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::current
     */
    public function testIterator(AliasInterface ...$aliases): void
    {
        $subject = new AliasIterator(...$aliases);

        $this->assertInstanceOf(AliasIterator::class, $subject);
        $this->assertEquals($aliases, iterator_to_array($subject));
    }

    /**
     * @return array
     */
    public function aliasProvider(): array
    {
        return [
            [],
            [$this->createMock(AliasInterface::class)],
            [
                $this->createMock(AliasInterface::class),
                $this->createMock(AliasInterface::class),
                $this->createMock(AliasInterface::class),
            ],
        ];
    }
}
