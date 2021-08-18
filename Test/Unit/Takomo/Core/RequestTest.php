<?php
namespace Test\Unit\Takomo\Core;

use Takomo\Core\Request;
use Takomo\Core\Tools\Normalize;
use Takomo\Core\Tools\SuperGlobals;

class RequestTest extends AbstractTest
{
    private Request $request;

    protected function setUp(): void
    {
        $normalize = new Normalize();

        $superGlobals_mock = $this->createMock(SuperGlobals::class);
        $superGlobals_mock->expects($this->any())
            ->method('get')
            ->will($this->returnValue([]));
        $superGlobals_mock->expects($this->any())
            ->method('post')
            ->will($this->returnValue([]));
        $superGlobals_mock->expects($this->any())
            ->method('server')
            ->will($this->returnValueMap(
                    [
                        ['REQUEST_METHOD', 'GET'],
                        ['REQUEST_URI', '/test/core/index']
                    ]
                )
            );
        $this->request = new Request($normalize, $superGlobals_mock);
    }

    public function testExecute() : void
    {
        $result = $this->request->execute();
        $this->assertCount(2, $result);
        $this->assertEquals('\\{vendor}\\Test\\Controller\\CoreController', $result[0]);
        $this->assertEquals('index', $result[1]);
    }
}