<?php
namespace Takomo\Core\Tools;

/**
 * Template syntax
 * SImple variable {{ variable }}
 * Template {% template_block %}
 * List of variables {{ foreach variable template }}
 */
class TemplateLoader
{
    public function parseVariables(string $template, array $variables, array $templates) : string
    {
        $regex = "/{{(.*?)}}/";
        preg_match_all($regex, $template, $matches);
        foreach($matches[0] as $key => $match) {
            $found = false;
            $map_key = trim($matches[1][$key]) ?? null;
            if ($map_key !== null) {
                if (isset($variables[$map_key])) {
                    $template = str_replace($match, $variables[$map_key], $template);
                    $found = true;
                } else {
                    $parts = explode(' ', $map_key);
                    $array_result = $this->parseArrayVariables($parts, $variables, $templates);
                    if ($array_result) {
                        $template = str_replace($match, $array_result, $template);
                    }
                }
                
            }

            if (!$found) {
                $template = str_replace($match, '', $template);
            }
        }

        return $template;
    }

    public function parseBlocks(string $template, array $templates) : string
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

        return $this->parseBlocks($template, $templates);
    }

    public function parseArrayVariables(array $parts, array $variables, array $templates) : string
    {
        $variable = $parts[1];
        $template = $parts[2] ?? null;
        $result = '';
        if ($parts[0] === 'foreach') {
            $sub_array = (array) $variables[$variable] ?? [];
            if ($template) {
                $template_base = file_get_contents($templates[$template]);
                foreach ($sub_array as $item) {
                    $tmp_template = $template_base;
                    $result .= $this->parseVariables($tmp_template, $item, $templates);
                }
            }
            
        }
        return $result;
    }
}