<?php
namespace Test\Unit\Takomo\Core;

use Takomo\Core\Config;
use Takomo\Core\Logger;

class LoggerTest extends AbstractTest
{
    private Logger $logger;

    private string $error_log = '';
    private string $debug_log = '';

    protected function setUp(): void
    {
        $this->error_log = LOG_PATH . '/error.log';
        $this->debug_log = LOG_PATH . '/debug.log';
        $config_mock = $this->createMock(Config::class);
        $config_mock->expects($this->any())
            ->method('getConfig')
            ->with($this->equalTo('debug'))
            ->will($this->returnValue('1'));
        $this->logger = new Logger($config_mock);

        file_put_contents($this->debug_log, '');
        file_put_contents($this->error_log, '');
    }

    protected function tearDown(): void
    {
        file_put_contents($this->debug_log, '');
        file_put_contents($this->error_log, '');
    }

    public function testError()
    {
        $this->logger->error('kaboom!');
        $result = file_get_contents($this->error_log);
        $this->assertStringContainsString('kaboom!', $result);

        $date = date('Y-m-d');
        $this->assertStringContainsString($date, $result);
    }

    public function testDebug()
    {
        $this->logger->debug('yoyo');
        $result = file_get_contents($this->debug_log);
        $this->assertStringContainsString('yoyo', $result);
    }
}