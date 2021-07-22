<?php
namespace Takomo\Core;

use Takomo\Core\Tools\TemplateLoader;

class Response
{
    private string $body = '';

    private array $headers = [];

    private int $response_code = 0;

    public function body(?string $body = null) : string
    {
        if ($body !== null) {
            $this->body = $body;
        }
        return $this->body;
    }

    public function render(array $templates, array $variables) : string
    {
        $this->headers();
        $this->body = file_get_contents($templates['base']);
        unset($templates['base']);
        $this->body = TemplateLoader::parseBlocks($this->body, $templates);
        $this->body = TemplateLoader::parseVariables($this->body, $variables, $templates);

        return $this->body;
    }

    public function setHeaders(array $headers) : void
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    private function headers() : void
    {
        if (in_array('Location', $this->headers)) {
            header('Location: ' . $this->headers['Location'], true, $this->response_code);
        } else {
            http_response_code($this->response_code);
            foreach ($this->headers as $key => $header) {
                header("$key: $header");
            }
        }
    }

    public function setResponseCode(int $response_code) : void
    {
        $this->response_code = $response_code;
    }
}