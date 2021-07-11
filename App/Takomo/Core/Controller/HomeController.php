<?php
namespace Takomo\Core\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->setVariables([
            'title' => 'Etusivu',
            'hello' => 'terve vaan'
        ]);
        $this->render();
    }
}