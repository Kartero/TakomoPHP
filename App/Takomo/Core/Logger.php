<?php
namespace Takomo\Core;

class Logger
{
    public function __construct(
        private Config $config
    ) { }

    public function write(string $file, string $text) : void
    {
        $text = date('Y-m-d H:i:s') . ' ' . $text . PHP_EOL;

        $full_file = LOG_PATH . "/$file";
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH, 0755, true);
        }

        if (!file_exists($full_file)) {
            $fp = fopen($full_file, 'w');
            fclose($fp);
            chmod($full_file, 0777);
        }

        if ($fp = fopen($full_file,'a')) {
            $start_time = microtime();
            do {
                $can_write=flock($fp,LOCK_EX);
                if (!$can_write) {
                    usleep(round(rand(0,100)*1000));
                }
            } while ((!$can_write) && ((microtime() - $start_time) < 1000));
            if ($can_write) {
                fwrite($fp,$text);
            }
            fclose($fp);
        }
    }

    public function error(string $text) : void
    {
        $this->write('error.log', $text);
    }

    public function debug(string $text) : void
    {
        $debug = (int) $this->config->getConfig('debug');
        if ($debug > 0) {
            $this->write('debug.log', $text);
        }
    }
}