<?php
namespace Takomo\Core\Api;

use Takomo\Core\Request;
use Takomo\Core\Response;

interface ControllerInterface
{
    public function getRequest() : Request;

    public function getResponse() : Response;

    public function setTemplate(string $part, string $path): void;

    public function setVariable(string $key, $value): void;
}