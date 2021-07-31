<?php
namespace Takomo\Core;

use ReflectionClass;
use Takomo\Core\Api\ControllerInterface;
use Takomo\Core\Controller\HomeController;
use Takomo\Core\Tools\Url;

class Bootstrap
{
    public function __construct(
        private Autowire $autowire,
        private Request $request,
        private Response $response,
        private Config $config,
        private Logger $logger
    ) { }

    public function execute()
    {
        try {
            $controller_parts = $this->request->execute();
            $class = $this->getControllerClass($controller_parts[0]);
            $controller = $this->autowire->di($class);
            if ($controller instanceof ControllerInterface) {
                $controller->setRequest($this->request);
                $controller->setResponse($this->response);
                $method = $controller_parts[1];
                $reflection_class = new ReflectionClass($class);
                if (!$reflection_class->hasMethod($method)) {
                    throw new \Exception("Action {$method} does not exist in {$class}");
                }
                $method_params = $reflection_class->getMethod($method)->getParameters();
                $param_count = count($method_params);
                $request_params = $this->request->getRequestParams();
                if (count($request_params) != $param_count) {
                    throw new \Exception("{$class}::{$method} expects {$param_count} parameters!");
                }
                
                $controller->beforeRender();
                $controller->{$method}(...$request_params);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $redirect_url = Url::getUrl('/core/not_found/error');
            header("Location: $redirect_url", true, 302);
        }
        
        echo $this->response->body();
    }

    private function getControllerClass(string $class) : string
    {
        $vendors = (array) $this->config->getConfigArray('vendor');
        foreach ($vendors as $vendor) {
            $class_name = str_replace('{vendor}', $vendor, $class);
            if (class_exists($class_name)) {
                return $class_name;
            }
        }

        throw new \Exception("Controller {$class} does not exist!");
    }
}