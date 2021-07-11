<?php
namespace Takomo\Core\Api;

use Takomo\Core\Request;
use Takomo\Core\Response;

interface ControllerInterface
{
    public function getRequest() : Request;

    public function getReponse() : Response;
}