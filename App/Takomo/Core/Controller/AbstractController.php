<?php
namespace Takomo\Core\Controller;

use Takomo\Core\Api\ControllerInterface;
use Takomo\Core\Request;
use Takomo\Core\Response;

abstract class AbstractController implements ControllerInterface
{
    public function __construct(
        protected Request $request, 
        protected Response $response
    ) { }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getReponse(): Response
    {
        return $this->response;
    }
}