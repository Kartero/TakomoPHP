<?php
namespace Takomo\Core\Controller;

use Takomo\Core\Api\ControllerInterface;
use Takomo\Core\Logger;
use Takomo\Core\Request;
use Takomo\Core\Response;
use Takomo\Core\Tools\Normalize;

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

    public function setTemplates(array $templates) : void
    {
        foreach ($templates as $name => $template) {
            $this->setTemplate($name, $template);
        }
    }

    public function setVariable(string $key, $value): void
    {
        $this->variables[$key] = $value;
    }

    public function beforeRender() : void
    {
        $templates = [
            'base' => 'base',
            'menu' => 'Layout/menu',
            'menu-item' => 'Layout/Menu/menu-item',
            'footer' => 'Layout/footer',
            'banner' => 'Layout/banner'
        ];

        $this->setTemplates($templates);
        $content_path = implode('/', Normalize::sctpcArray(
            $this->getRequest()->getRequestParts(), 
            [
                'keep_last' => true
            ])
        );
        $this->setTemplate('content', $content_path);

        $this->setVariables([
            'title' => str_replace('Controller', '', static::class),
            'hello' => 'terve vaan',
            'home_url' => '/',
            'menu-items' => $this->menu()
        ]);
    }

    public function setVariables(array $variables) : void
    {
        foreach($variables as $key => $value) {
            $this->setVariable($key, $value);
        }
    }

    public function render() : string
    {
        return $this->getResponse()->render($this->templates, $this->variables);
    }

    public function redirect(string $url, int $response_code = 302) : void
    {
        $this->getResponse()->setHeaders(['Location', $url]);
        $this->getResponse()->setResponseCode($response_code);
        $this->render();
    }

    protected function menu() : array
    {
        return [
                [
                    'link' => '/',
                    'title' => 'Crm'
                ],
                [
                    'link' => '/home',
                    'title' => 'Blogi'
                ]
            ];
    }
}