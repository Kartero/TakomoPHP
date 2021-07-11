<?php
namespace Takomo\Core;

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
        foreach ($templates as $key => $template) {
            $tmp_template = file_get_contents($template);
            $this->body = str_replace("{% $key %}", $tmp_template, $this->body);
        }

        foreach ($variables as $key => $value) {
            $this->body = str_replace("{{ $key }}", $value, $this->body);
        }

        return $this->body;
    }
}