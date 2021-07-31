<?php
namespace Test\Unit\Takomo\Core;

use PHPUnit\Framework\TestCase;
use Test\TestBase;

abstract class AbstractTest extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $testBase = new TestBase();
        parent::__construct($name, $data, $dataName);
    }    
}