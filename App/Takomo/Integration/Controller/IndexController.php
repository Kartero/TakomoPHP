<?php
namespace Takomo\Integration\Controller;

use Takomo\Core\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        $this->response->body('integraatio index');
    }

    public function second(int $id)
    {
        $this->response->body('integraatio second ' . $id);
    }
}