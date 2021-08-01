<?php
namespace Test\Unit\Takomo\Core\Tools;

use Takomo\Core\Tools\Normalize;
use Test\Unit\Takomo\Core\AbstractTest;

class NormalizeTest extends AbstractTest
{
    private Normalize $normalize;

    protected function setUp(): void
    {
        $this->normalize = new Normalize();
    }

    public function testSnakeCase() : void
    {
        $string = 'first_second_third';
        $result = $this->normalize->snakeCaseToPascalCase($string);
        $this->assertEquals('FirstSecondThird', $result);
    }

    public function testSctpArray() : void
    {
        $parts = [
            'first',
            'second',
            'third'
        ];
        $options = [
            'keep_last' => true
        ];

        $result = $this->normalize->sctpcArray($parts, $options);
        $expected = [
            'First',
            'Second',
            'third'
        ];
        $this->assertEquals($expected, $result);
    }
}