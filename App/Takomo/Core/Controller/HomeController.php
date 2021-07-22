<?php
namespace Takomo\Core\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->setVariables([
            'hello' => 'terve vaan'
        ]);
        $this->render();
    }
}