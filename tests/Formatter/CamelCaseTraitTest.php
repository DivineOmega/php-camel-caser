<?php

namespace DivineOmega\CamelCaser\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use DivineOmega\CamelCaser\Formatter\CamelCaseTrait;

/**
 * @coversDefaultClass \DivineOmega\CamelCaser\Formatter\CamelCaseTrait
 */
class CamelCaseTraitTest extends TestCase
{
    /**
     * @dataProvider stringProvider
     *
     * @param string $original
     * @param string $expected
     *
     * @return void
     *
     * @covers ::camelCase
     */
    public function testCamelCase(string $original, string $expected): void
    {
        /** @var CamelCaseTrait $subject */
        $subject = $this->getMockForTrait(CamelCaseTrait::class);

        $this->assertEquals($expected, $subject::camelCase($original));
    }

    /**
     * @return array
     */
    public function stringProvider(): array
    {
        return [
            ['foo_bar', 'fooBar'],
            ['foo-bar', 'fooBar'],
            ['fooBar', 'fooBar'],
            ['foo-bar_bazQux', 'fooBarBazQux'],
            ['FOOBAR', 'fOOBAR'],
            ['FOO-BAR', 'fOOBAR']
        ];
    }
}
