<?php
namespace Takomo\Core;

class Bootstrap
{
    public function __construct(
        private Request $request,
        private Response $response
    ) { }

    public function execute()
    {
        echo 'Hello';
        $this->request->execute();
        $this->response->body();
    }
}