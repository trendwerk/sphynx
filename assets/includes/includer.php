<?php
/**
 * Include an entire folder of files
 */

namespace Trendwerk\TrendPress;

final class Includer
{
    public function __construct($folder)
    {
        if (is_dir($folder)) {
            foreach (scandir($folder) as $inc) {
                if ('.' == substr($inc, 0, 1)) {
                    continue;
                }
                
                if ('.php' != substr($inc, -4)) {
                    continue;
                }

                $inc = $folder . $inc;

                if (is_readable($inc)) {
                    include_once($inc);
                }
            }
        }
    }
}
