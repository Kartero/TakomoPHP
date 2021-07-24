<?php
namespace Takomo\Core;

class Config
{
    const CONFIG_FILE = ROOT_PATH . '/env.cnf';

    private static $config;

    public static function loadConfig(?string $file = null) : void
    {
        if (!$file) {
            $file = self::CONFIG_FILE;
        } 
        $config = (array) file($file, FILE_SKIP_EMPTY_LINES);

        $external_config_files = [];
        foreach ($config as $entry) {
            $parts = explode('=', $entry);

            if (count($parts) < 2) {
                continue;
            }

            $keys = explode('.', $parts[0]);
            $value = $parts[1];

            if ($keys[0] === 'config') {
                $external_config_files[] = $value;
                continue;
            }
            
            $count = count($keys);
            // TODO! Use some generic and more flexible approach!
            switch ($count) {
                case 1:
                    self::$config[$keys[0]] = $value;
                    break;
                case 2:
                    self::$config[$keys[0]][$keys[1]] = $value;
                    break;
                case 3:
                    self::$config[$keys[0]][$keys[1]][$keys[2]] = $value;
                    break;
            }
        }

        foreach ($external_config_files as $config_file) {
            self::loadConfig($config_file);
        }
    }

    public static function getConfig(string $path) : string
    {
        $keys = explode('.', $path);
        $value = '';
        $count = count($keys);
        // TODO! Use some generic and more flexible approach!
        switch ($count) {
            case 1:
                $value = self::$config[$keys[0]];
                break;
            case 2:
                $value = self::$config[$keys[0]][$keys[1]];
                break;
            case 3:
                $value = self::$config[$keys[0]][$keys[1]][$keys[2]];
                break;
        }

        return $value;
    }

    public static function getConfigArray(string $path) : array
    {
        $keys = explode('.', $path);
        $value = '';
        $count = count($keys);
        // TODO! Use some generic and more flexible approach!
        switch ($count) {
            case 1:
                $value = self::$config[$keys[0]];
                break;
            case 2:
                $value = self::$config[$keys[0]][$keys[1]];
                break;
            case 3:
                $value = self::$config[$keys[0]][$keys[1]][$keys[2]];
                break;
        }

        return $value;
    }
}