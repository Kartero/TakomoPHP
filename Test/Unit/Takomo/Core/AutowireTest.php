<?php
namespace Test\Unit\Takomo\Core;

use Takomo\Core\Autowire;
use Test\Fixtures\classes\A;
use Test\Fixtures\classes\B;

class AutowireTest extends AbstractTest
{
    private Autowire $autowire;

    protected function setUp(): void
    {
        $this->autowire = new Autowire();
    }

    public function testDi()
    {
        $a = $this->autowire->di(A::class);
        $this->assertInstanceOf(A::class, $a);

        $b = $a->getB();
        $this->assertInstanceOf(B::class, $b);

        $c = $a->getC();
        $this->assertNull($c);
    }
}