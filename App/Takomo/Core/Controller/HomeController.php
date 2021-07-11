<?php
namespace Takomo\Core\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->response->body('etusivu');
    }
}