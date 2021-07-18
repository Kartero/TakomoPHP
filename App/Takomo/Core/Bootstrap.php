<?php
namespace Takomo\Core;

use ReflectionClass;
use Takomo\Core\Api\ControllerInterface;

class Bootstrap
{
    public function __construct(
        private Request $request,
        private Response $response
    ) { }

    public function execute()
    {
        try {
            $controller_parts = $this->request->execute();
            $class = $this->getControllerClass($controller_parts[0]);
            $controller = new $class($this->request, $this->response);
            if ($controller instanceof ControllerInterface) {
                $method = $controller_parts[1];
                $reflection_class = new ReflectionClass($class);
                if (!$reflection_class->hasMethod($method)) {
                    throw new \Exception("Action {$method} does not exist in {$class}");
                }
                $method_params = $reflection_class->getMethod($method)->getParameters();
                $param_count = count($method_params);
                $request_params = $this->request->getRequestParams();
                if (count($request_params) != $param_count) {
                    throw new \Exception("{$class}:{$method} expects {$param_count} parameters!");
                }
                
                $controller->beforeRender();
                $controller->{$method}(...$request_params);
            }
        } catch (\Exception $e) {
            Logger::write('error.log', $e->getMessage());
        }
        

        echo $this->response->body();
    }

    private function getControllerClass(string $class) : string
    {
        $vendors = (array) Config::getConfigArray('vendor');
        foreach ($vendors as $vendor) {
            $class_name = str_replace('{vendor}', $vendor, $class);
            if (class_exists($class_name)) {
                return $class_name;
            }
        }

        throw new \Exception("Controller {$class} does not exist!");
    }
}