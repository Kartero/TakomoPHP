<?php
namespace Takomo\Core\Tools;

class SuperGlobals
{
    public static function get() : array
    {
        return $_GET;
    }

    public static function post() : array
    {
        return $_POST;
    }

    public static function server(string $variable) : string
    {
        return $_SERVER[$variable];
    }
}