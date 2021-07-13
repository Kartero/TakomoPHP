<?php
namespace Takomo\Core\Tools;

class Normalize
{
    public static function snakeCaseToPascalCase(string $string) : string
    {
        $parts = explode('_', strtolower($string));
        return implode('', array_map("ucfirst", $parts));;
    }
}