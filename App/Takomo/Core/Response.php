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
}