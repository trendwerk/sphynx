<?php
/**
 * Composer install script
 */

namespace Trendwerk\TrendPress;

use Composer\Script\Event;

final class Installer
{
    public static function setNamespace($event)
    {
        $defaultNamespace = __NAMESPACE__;
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $namespace = $io->ask('What namespace would you like to use? [default: ' . $defaultNamespace . '] ', $defaultNamespace);

        if ($namespace == $defaultNamespace || 0 == strlen($namespace)) {
            $io->write('<info>Using default namespace</info>');
            return 1;
        }

        self::renameNamespace($namespace);

        return 1;
    }

    public static function renameNamespace($namespace)
    {
        $root = dirname(dirname(__DIR__));
    }
}
