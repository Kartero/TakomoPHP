<?php
namespace Takomo\Core;

use Takomo\Core\Api\ControllerInterface;

class Bootstrap
{
    public function __construct(
        private Request $request,
        private Response $response
    ) { }

    public function execute()
    {
        $controller_parts = $this->request->execute();
        $class = $controller_parts[0];
        $controller = new $class($this->request, $this->response);
        if ($controller instanceof ControllerInterface) {
            $method = $controller_parts[1];
            $controller->beforeRender();
            $controller->{$method}();
        }

        echo $this->response->body();
    }
}