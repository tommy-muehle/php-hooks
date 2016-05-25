<?php

namespace PhpHooks\Utility;

/**
 * Class GitUtility
 *
 * @package PhpHooks\Utility
 */
class GitUtility
{
    /**
     * @return string
     */
    public static function getGitDir()
    {
        $path = array();
        exec("git rev-parse --show-toplevel", $path);

        return current($path);
    }

    /**
     * Thanks to @sascha (https://github.com/sascha-seyfert)
     *
     * @return array
     */
    public static function extractFiles($onlyStaged = true)
    {
        $output = array();

        $getDiffCommand = 'git diff --name-status --diff-filter=ACMR';

        if ($onlyStaged === true) {
            $getDiffCommand = 'git diff --cached --name-status --diff-filter=ACMR';
        }
        exec($getDiffCommand, $output);

        $files = array_map(function($v) {
            $file = trim(preg_replace('/^([ACMR]{1})\s{1,}/', '', $v));
            return self::getGitDir() . DIRECTORY_SEPARATOR . $file;
        }, $output);

        return $files;
    }
}
