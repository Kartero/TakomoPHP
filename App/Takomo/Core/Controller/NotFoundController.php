<?php
namespace Takomo\Core\Controller;

class NotFoundController extends AbstractController
{
    public function index()
    {
        $this->getResponse()->setResponseCode(404);
        $this->render();
    }

    public function error()
    {
        $this->getResponse()->setResponseCode(500);
        $this->render();
    }
}