<?php
namespace Takomo\Core;

use Takomo\Core\Tools\Normalize;
use Takomo\Core\Tools\SuperGlobals;

class Request
{
    private array $get = [];

    private array $post = [];

    private $method;

    private string $request_uri;

    private array $request_parts = [];

    private array $request_params = [];

    public function __construct(
        private Normalize $normalize,
        private SuperGlobals $superGlobals
    ) { }

    public function execute() : array
    {
        $this->extractRequest();

        return $this->getController();
    }

    public function getParams() : array
    {
        return $this->get;
    }

    public function postParams() : array
    {
        return $this->post;
    }

    public function isGet() : bool
    {
        return $this->method == 'GET';
    }

    public function isPost() : bool
    {
        return $this->method == 'POST';
    }

    public function getController() : array
    {
        $parts = explode('/', $this->request_uri);
        $parts_count = count($parts);
        if ($parts_count < 2) {
            $parts = [
                'core',
                'home'
            ];
        }

        if ($parts_count > 3) {
            for ($i = 3; $i < $parts_count; $i++) {
                $this->request_params[] = $parts[$i];
            }
        }

        $controller = sprintf(
            '\\{vendor}\\%s\\Controller\\%sController', 
            $this->normalize->snakeCaseToPascalCase($parts[0]), 
            $this->normalize->snakeCaseToPascalCase($parts[1])
            );
            
        $method = $parts[2] ?? 'index';
        $parts[2] = $method;
        $this->request_parts = $parts;

        return [
            $controller,
            $method
        ];
    }

    private function extractRequest() : void
    {
        $this->get = $this->superGlobals->get();
        $this->post = $this->superGlobals->post();
        $this->method = $this->superGlobals->server('REQUEST_METHOD');
        $this->request_uri = substr($this->superGlobals->server('REQUEST_URI'), 1);
    }

    public function getRequestParts() : array
    {
        return $this->request_parts;
    }

    public function getRequestParams() : array
    {
        return $this->request_params;
    }
}