<?php

namespace DivineOmega\CamelCaser\Tests\Formatter;

use DivineOmega\CamelCaser\Formatter\FunctionFormatterInterface;
use DivineOmega\CamelCaser\Tests\CreateFunctionTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use DivineOmega\CamelCaser\Formatter\NamespacePrefixFormatter;
use ReflectionFunctionAbstract;

/**
 * @coversDefaultClass \DivineOmega\CamelCaser\Formatter\NamespacePrefixFormatter
 */
class NamespacePrefixFormatterTest extends TestCase
{
    use CreateFunctionTrait;

    /**
     * @return void
     *
     * @covers ::__construct
     */
    public function testConstructor(): void
    {
        /** @noinspection PhpParamsInspection */
        $this->assertInstanceOf(
            NamespacePrefixFormatter::class,
            new NamespacePrefixFormatter(
                $this->createMock(FunctionFormatterInterface::class)
            )
        );
    }

    /**
     * @dataProvider functionProvider
     *
     * @param ReflectionFunctionAbstract $function
     * @param string                     $expected
     *
     * @return void
     *
     * @covers ::__invoke
     */
    public function testInvoke(
        ReflectionFunctionAbstract $function,
        string $expected
    ): void {
        /** @var FunctionFormatterInterface|MockObject $formatter */
        $formatter = $this->createMock(FunctionFormatterInterface::class);
        $subject   = new NamespacePrefixFormatter($formatter);

        $formatter
            ->expects(self::once())
            ->method('__invoke')
            ->with(self::isInstanceOf(ReflectionFunctionAbstract::class))
            ->willReturnCallback(
                function (ReflectionFunctionAbstract $function): string {
                    return strtoupper($function->getShortName());
                }
            );

        $this->assertEquals($expected, $subject->__invoke($function));
    }

    /**
     * @return array
     */
    public function functionProvider(): array
    {
        return [
            [
                $this->createFunction('foo'),
                '\FOO'
            ],
            [
                $this->createFunction('Foo\Bar\baz'),
                '\Foo\Bar\BAZ'
            ]
        ];
    }
}
