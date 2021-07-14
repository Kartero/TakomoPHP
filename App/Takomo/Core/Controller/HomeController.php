<?php
namespace Takomo\Core\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->setVariables([
            'title' => 'Etusivu',
            'hello' => 'terve vaan',
            'home_url' => '/',
            'menu-items' => [
                [
                    'link' => '/',
                    'title' => 'Crm'
                ],
                [
                    'link' => '/home',
                    'title' => 'Blogi'
                ]
            ]
        ]);
        $this->render();
    }
}