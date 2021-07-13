<?php
namespace Takomo\Core;

use Takomo\Core\Tools\Normalize;

class Request
{
    private array $get = [];

    private array $post = [];

    private $method;

    private string $request_uri;

    private array $request_parts = [];

    public function execute() : array
    {
        $this->extractRequest();

        return $this->getController();
    }

    public function getParams()
    {
        return $this->get;
    }

    public function postParams()
    {
        return $this->post;
    }

    public function isGet()
    {
        return $this->method == 'GET';
    }

    public function isPost()
    {
        return $this->method == 'POST';
    }

    public function getController() : array
    {
        $parts = explode('/', $this->request_uri);
        if (count($parts) < 2) {
            $parts = [
                'Core',
                'Home'
            ];
        }

        $controller = sprintf(
            '\\Takomo\\%s\\Controller\\%sController', 
            Normalize::snakeCaseToPascalCase($parts[0]), 
            Normalize::snakeCaseToPascalCase($parts[1])
            );
            
        $method = $parts[2] ?? 'index';
        $parts[2] = $method;
        $this->request_parts = $parts;

        return [
            $controller,
            $method
        ];
    }

    private function extractRequest()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->request_uri = substr($_SERVER['REQUEST_URI'], 1);
    }

    public function getRequestParts()
    {
        return $this->request_parts;
    }
}