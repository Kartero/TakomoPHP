<?php
namespace Takomo\Core\Api;

use Takomo\Core\Request;
use Takomo\Core\Response;

interface ControllerInterface
{
    public function getRequest() : Request;

    public function getResponse() : Response;

    public function setRequest(Request $request) : void;

    public function setResponse(Response $response): void;

    public function setTemplate(string $part, string $path): void;

    public function setVariable(string $key, $value): void;

    public function render() : string;

    public function beforeRender() : void;
}