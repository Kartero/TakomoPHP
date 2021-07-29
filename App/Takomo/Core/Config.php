<?php
namespace Takomo\Core;

class Config
{
    const CONFIG_FILE = ROOT_PATH . '/env.cnf';

    private array $config = [];

    public function __construct()
    {
        $this->loadConfig();
    }

    private function loadConfig(?string $file = null) : void
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
                    $this->config[$keys[0]] = $value;
                    break;
                case 2:
                    $this->config[$keys[0]][$keys[1]] = $value;
                    break;
                case 3:
                    $this->config[$keys[0]][$keys[1]][$keys[2]] = $value;
                    break;
            }
        }

        foreach ($external_config_files as $config_file) {
            $this->loadConfig($config_file);
        }
    }

    public function getConfig(string $path) : string
    {
        $keys = explode('.', $path);
        $value = '';
        $count = count($keys);
        // TODO! Use some generic and more flexible approach!
        switch ($count) {
            case 1:
                $value = $this->config[$keys[0]];
                break;
            case 2:
                $value = $this->config[$keys[0]][$keys[1]];
                break;
            case 3:
                $value = $this->config[$keys[0]][$keys[1]][$keys[2]];
                break;
        }

        return $value;
    }

    public function getConfigArray(string $path) : array
    {
        $keys = explode('.', $path);
        $value = '';
        $count = count($keys);
        // TODO! Use some generic and more flexible approach!
        switch ($count) {
            case 1:
                $value = $this->config[$keys[0]];
                break;
            case 2:
                $value = $this->config[$keys[0]][$keys[1]];
                break;
            case 3:
                $value = $this->config[$keys[0]][$keys[1]][$keys[2]];
                break;
        }

        return $value;
    }
}