<?php
namespace Trendwerk\Sphynx;

use Composer\Script\Event;

final class Installer
{
    public static function setNamespace($event)
    {
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $root = dirname(dirname(__DIR__));
        $defaultNamespace = __NAMESPACE__;
        $question = '<question>What namespace would you like to use?</question>';

        $namespace = $io->ask($question . ' [<comment>' . $defaultNamespace . '</comment>] ', $defaultNamespace);

        if ($namespace == $defaultNamespace || 0 == strlen($namespace)) {
            $io->write('Using default namespace');
            return 1;
        }

        $changedFiles = self::renameNamespaceInDir($root, $defaultNamespace, $namespace);

        $io->write('Renamed namespace in ' . $changedFiles . ' files');

        return 1;
    }

    private static function renameNamespaceInDir($dir, $fromNamespace, $toNamespace)
    {
        $changedFiles = 0;
        $files = scandir($dir);

        if (count($files) == 0) {
            return;
        }

        foreach ($files as $file) {
            if (in_array($file, ['.', '..', 'node_modules', 'vendor'])) {
                continue;
            }

            $splitByDot = explode('.', $file);
            $extension = end($splitByDot);

            if ($extension == 'php') {
                $changed = self::renameNamespaceInFile($dir . '/' . $file, $fromNamespace, $toNamespace);

                if ($changed) {
                    $changedFiles++;
                }
            } elseif (is_dir($dir . '/' . $file)) {
                $changedFiles += self::renameNamespaceInDir($dir . '/' . $file, $fromNamespace, $toNamespace);
            }
        }

        return $changedFiles;
    }

    private static function renameNamespaceInFile($file, $fromNamespace, $toNamespace)
    {
        $_contents = $contents = file_get_contents($file);
        $contents = str_replace($fromNamespace, $toNamespace, $contents);

        if ($contents != $_contents) {
            file_put_contents($file, $contents);
            return true;
        }

        return false;
    }

    public static function setThemeData($event)
    {
        $io = $event->getIO();

        if (! $io->isInteractive()) {
            return 1;
        }

        $root = dirname(dirname(__DIR__));
        $style = $root . '/style.css';
        $contents = $_contents = file_get_contents($style);

        $settings = ['Theme Name', 'Theme URI', 'Description', 'Author', 'Author URI'];

        $currentSettings = [];
        $newSettings = [];

        foreach ($settings as $setting) {
            preg_match('/' . $setting . ':(.+)/', $contents, $value);

            if (isset($value[1]) && strlen(trim($value[1])) > 0) {
                $currentSettings[$setting] = trim($value[1]);
                $question = '<question>' . $setting . ':</question>';
                $comment = '[<comment>' . $currentSettings[$setting] . '</comment>]';

                $newSettings[$setting] = $io->ask($question . ' ' . $comment . ' ', $currentSettings[$setting]);
            }
        }

        foreach ($newSettings as $setting => $value) {
            if ($value == $currentSettings[$setting] || 0 == strlen($value)) {
                $io->write('Using default ' . $setting);
            } else {
                $regex = '/(.+)' . $setting . ': (\s+)(.+)/';
                $contents = preg_replace($regex, '$1' . $setting . ': $2' . $value, $contents);
            }
        }

        if ($contents != $_contents) {
            file_put_contents($style, $contents);
        }

        $io->write('<info>Hooray! You can now start developing something great.</info>');

        return 1;
    }
}
