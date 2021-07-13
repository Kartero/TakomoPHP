<?php
namespace Takomo\Core\Tools;

/**
 * Template syntax
 * {{ $variable }}
 * {% $template_block %} 
 */
class TemplateLoader
{
    public static function parseVariables(string $template, array $variables) : string
    {
        $regex = "/{{(.*?)}}/";
        preg_match_all($regex, $template, $matches);
        foreach($matches[0] as $key => $match) {
            $map_key = trim($matches[1][$key]) ?? null;
            if ($map_key !== null && isset($variables[$map_key])) {
                $template = str_replace($match, $variables[$map_key], $template);
            } else {
                $template = str_replace($match, '', $template);
            }
        }

        return $template;
    }

    public static function parseBlocks(string $template, array $templates) : string
    {
        $regex = "/{%(.*?)%}/";
        preg_match_all($regex, $template, $matches);

        if (empty($matches[0])) {
            return $template;
        }

        foreach($matches[0] as $key => $match) {
            $map_key = trim($matches[1][$key]) ?? null;
            if ($map_key !== null && isset($templates[$map_key])) {
                $tmp_template = file_get_contents($templates[$map_key]);
                $template = str_replace($match, $tmp_template, $template);
            } else {
                $template = str_replace($match, '', $template);
            }
        }

        return self::parseBlocks($template, $templates);
    }
}