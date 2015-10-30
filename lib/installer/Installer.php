<?php
/**
 * Composer install script
 */

namespace Trendwerk\TrendPress;

use Composer\Script\Event;

final class Installer
{
    /**
     * Set namespace for theme
     */
    public static function setNamespace($event)
    {
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $root = dirname(dirname(__DIR__));
        $defaultNamespace = __NAMESPACE__;

        $namespace = $io->ask('<question>What namespace would you like to use?</question> [<comment>' . $defaultNamespace . '</comment>] ', $defaultNamespace);

        if ($namespace == $defaultNamespace || 0 == strlen($namespace)) {
            $io->write('Using default namespace');
            return 1;
        }

        $changedFiles = self::renameNamespaceInDir($root, $defaultNamespace, $namespace);

        $io->write('Renamed namespace in ' . $changedFiles . ' files');

        return 1;
    }

    /**
     * Rename namespace for all files in directory (recursively)
     *
     * @param string $dir Directory which to rename
     * @param string $fromNamespace
     * @param string $toNamespace
     */
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
            } else if (is_dir($dir . '/' . $file)) {
                $changedFiles += self::renameNamespaceInDir($dir . '/' . $file, $fromNamespace, $toNamespace);
            }
        }

        return $changedFiles;
    }

    /**
     * Rename namespace in file
     *
     * @param string $file
     * @param string $fromNamespace
     * @param string $toNamespace
     */
    public static function renameNamespaceInFile($file, $fromNamespace, $toNamespace)
    {
        $_contents = $contents = file_get_contents($file);
        $contents = str_replace($fromNamespace, $toNamespace, $contents);

        if ($contents != $_contents) {
            file_put_contents($file, $contents);
            return true;
        }

        return false;
    }

    /**
     * Set theme data
     */
    public static function setThemeData($event)
    {
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $root = dirname(dirname(__DIR__));
        $style = $root . '/style.css';
        $contents = $_contents = file_get_contents($style);

        $settings = array('Theme Name', 'Theme URI', 'Description', 'Author', 'Author URI');

        $currentSettings = array();
        $newSettings = array();

        foreach ($settings as $setting) {
            preg_match('/' . $setting . ':(.+)/', $contents, $value);

            if (isset($value[1]) && strlen(trim($value[1])) > 0) {
                $currentSettings[$setting] = trim($value[1]);

                $newSettings[$setting] = $io->ask('<question>' . $setting . ':</question> [<comment>' . $currentSettings[$setting] . '</comment>] ', $currentSettings[$setting]);
            }
        }

        foreach ($newSettings as $setting => $value) {
            if ($value == $currentSettings[$setting] || 0 == strlen($value)) {
                $io->write('Using default ' . $setting);
            } else {
                $contents = preg_replace('/(.+)' . $setting . ': (\s+)(.+)/', '$1' . $setting . ': $2' . $value, $contents);
            }
        }

        if ($contents != $_contents) {
            file_put_contents($style, $contents);
        }

        $io->write('<info>Hooray! You can now start developing something great.</info>');

        return 1;
    }
}
