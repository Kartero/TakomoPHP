<?php
namespace Test\Fixtures\classes;

class A
{
    private ?C $c = null;

    public function __construct(
        private B $b
    ) { }

    public function getB()
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }
}