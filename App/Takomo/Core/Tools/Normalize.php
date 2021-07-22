<?php
namespace Takomo\Core\Tools;

class Normalize
{
    public static function snakeCaseToPascalCase(string $string) : string
    {
        $parts = explode('_', strtolower($string));
        return implode('', array_map("ucfirst", $parts));;
    }

    public static function sctpcArray(array $parts, array $options = []) : array
    {
        $tmp_array = [];
        $keep_last = $options['keep_last'] ?? false;

        $count = count($parts);
        $i = 0;
        foreach ($parts as $part) {
            $i++;
            if ($keep_last && $i == $count) {
                $tmp_array[] = $part;
                continue;
            }
            $tmp_array[] = self::snakeCaseToPascalCase($part);
        }
        return $tmp_array;
    }
}