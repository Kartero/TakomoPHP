<?php
namespace Takomo\Core;

use Takomo\Core\Tools\TemplateLoader;

class Response
{
    private string $body;

    public function body(?string $body = null)
    {
        if ($body !== null) {
            $this->body = $body;
        }
        return $this->body;
    }

    public function render(array $templates, array $variables) : string
    {
        $this->body = file_get_contents($templates['base']);
        unset($templates['base']);
        $this->body = TemplateLoader::parseBlocks($this->body, $templates);
        $this->body = TemplateLoader::parseVariables($this->body, $variables);

        return $this->body;
    }
}