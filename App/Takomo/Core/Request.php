<?php
namespace Takomo\Core;

class Request
{
    private array $get = [];

    private array $post = [];

    private $method;

    private string $request_uri;

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
            $controller = '\Takomo\Core\Controller\HomeController';
            $method = 'index';
        } else {
            $controller = '';
            $method = '';
        }

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


}