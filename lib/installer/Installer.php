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
        $root = dirname(dirname(__DIR__));
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $namespace = $io->ask('What namespace would you like to use? [default: ' . $defaultNamespace . '] ', $defaultNamespace);

        if ($namespace == $defaultNamespace || 0 == strlen($namespace)) {
            $io->write('<info>Using default namespace</info>');
            return 1;
        }

        $changedFiles = self::renameNamespaceInDir($root, $defaultNamespace, $namespace);

        $io->write('<info>Renamed namespace in ' . $changedFiles . ' files</info>');

        return 1;
    }

    public static function renameNamespaceInDir($dir, $fromNamespace, $toNamespace)
    {
        $changedFiles = 0;
        $files = scandir($dir);

        if (count($files) == 0) {
            return;
        }

        foreach ($files as $file) {
            $extension = end((explode('.', $file)));

            if (in_array($file, array('.', '..', 'node_modules', 'vendor'))) {
                continue;
            }

            if ($extension == 'php') {
                $changed = self::renameNamespaceInFile($dir . '/' . $file, $fromNamespace, $toNamespace);

                if ($changed) {
                    $changedFiles++;
                }
            } else if(is_dir( $dir . '/' . $file )) {
                $changedFiles += self::renameNamespaceInDir($dir . '/' . $file, $fromNamespace, $toNamespace);
            }
        }

        return $changedFiles;
    }

    public static function renameNamespaceInFile($file, $fromNamespace, $toNamespace) {
        $_contents = $contents = file_get_contents($file);
        $contents = str_replace($fromNamespace, $toNamespace, $contents);

        if ($contents != $_contents) {
            file_put_contents($file, $contents);
            return true;
        }

        return false;
    }
}
