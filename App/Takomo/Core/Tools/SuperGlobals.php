<?php
namespace Takomo\Core\Tools;

class SuperGlobals
{
    public function get() : array
    {
        return $_GET;
    }

    public function post() : array
    {
        return $_POST;
    }

    public function server(string $variable) : string
    {
        return $_SERVER[$variable];
    }
}