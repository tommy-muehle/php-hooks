<?php

namespace PhpHooks\Utility;

/**
 * Class GitUtility
 * Thanks to @sascha (https://github.com/sascha-seyfert)
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
     * @return array
     */
    public static function extractStagedFiles()
    {
        $output = array();
        exec('git diff --cached --name-status --diff-filter=ACMR', $output);


        return self::addPathToFiles($output);
    }

    /**
     * @return array
     */
    public static function extractUnstagedFiles()
    {
        $output = array();
        exec('git diff --name-status --diff-filter=ACMR', $output);


        return self::addPathToFiles($output);
    }

    /**
     * @return array
     */
    public static function extractUntrackedFiles()
    {
        $output = array();
        exec('git clean --dry-run | awk \'{print $3;}\'', $output);


        return self::addPathToFiles($output);
    }

    /**
     * Add absolutely path to filename
     *
     * @param array $output
     * @return array
     */
    private static function addPathToFiles(array $output)
    {
        $files = array_map(function ($rawFileName) {
            $file = trim(preg_replace('/^([ACMR]{1})\s{1,}/', '', $rawFileName));
            return self::getGitDir() . DIRECTORY_SEPARATOR . $file;
        }, $output);

        return $files;
    }

    /**
     * Extract staged, unstaged and untracked files
     *
     * @return array
     */
    public static function extractAllFiles()
    {
        $untrackedFiles = self::extractUntrackedFiles();
        $unstagedFiles = self::extractUnstagedFiles();
        $stagedFiles = self::extractStagedFiles();

        $files = array_merge($stagedFiles, $unstagedFiles, $untrackedFiles);

        return $files;
    }
}
