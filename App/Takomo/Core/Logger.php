<?php
namespace Takomo\Core;

class Logger
{
    public static function write(string $file, string $text) : void
    {
        $full_file = LOG_PATH . '/$file';
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH, 0755, true);
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
}