<?php
namespace Takomo\Core\Tools;

class Url
{
    public static function getUrl(string $path) : string
    {
        return BASE_URL . $path;
    }
}