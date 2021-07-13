<?php
namespace Takomo\Core\Controller;

use Takomo\Core\Api\ControllerInterface;
use Takomo\Core\Request;
use Takomo\Core\Response;

abstract class AbstractController implements ControllerInterface
{
    protected array $templates = [];

    protected array $variables = [];

    public function __construct(
        protected Request $request, 
        protected Response $response
    ) { }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setTemplate(string $part, string $path): void
    {
        $this->templates[$part] = VIEW_PATH . '/' . $path . '.html';
    }

    public function setVariable(string $key, $value): void
    {
        $this->variables[$key] = $value;
    }

    public function beforeRender() : void
    {
        $this->setTemplate('base',  'base');
        $this->setTemplate('menu',  'Layout/menu');
        $this->setTemplate('footer',  'Layout/footer');
        $content_path = implode('/', $this->getRequest()->getRequestParts());
        $this->setTemplate('content', $content_path);
    }

    public function setVariables(array $variables) : void
    {
        foreach($variables as $key => $value) {
            $this->setVariable($key, $value);
        }
    }

    public function render() : string
    {
        return $this->response->render($this->templates, $this->variables);
    }
}