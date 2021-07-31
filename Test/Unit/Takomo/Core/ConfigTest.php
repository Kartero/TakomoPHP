<?php
namespace Test\Unit\Takomo\Core;

use Takomo\Core\Config;

class ConfigTest extends AbstractTest
{
    private Config $config;

    protected function setUp(): void
    {
        $env_file = FIXTURE_DIR . '/test_config.env';
        $this->config = new Config($env_file);
    }

    public function testGetConfig() : void
    {
        $value = $this->config->getConfig('debug');
        $this->assertEquals('2', $value);

        $value = $this->config->getConfig('two.dimension');
        $this->assertEquals('9', $value);
    }

    public function testGetConfigArray() : void
    {
        $array = $this->config->getConfigArray('one.two');
        $this->assertCount(2, $array);
        $this->assertArrayHasKey('four', $array);
    }
}