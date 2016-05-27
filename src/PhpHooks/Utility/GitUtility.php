<?php

namespace PhpHooks\Utility;

use PhpHooks\Exception\InvalidParamException;

/**
 * Class GitUtility
 *
 * @package PhpHooks\Utility
 */
class GitUtility
{
    const LIST_TYPE_UNTRACKED = 'untracked';
    const LIST_TYPE_STAGED = 'staged';
    const LIST_TYPE_UNSTAGE = 'unstaged';

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
     * @param string $listType Valid list types are stage, unstaged and untracked
     * @return array
     */
    public static function extractFiles($listType = 'staged')
    {
        $output = array();

        switch ($listType) {
            case self::LIST_TYPE_STAGED:
                $getDiffCommand = 'git diff --cached --name-status --diff-filter=ACMR';
                break;
            case self::LIST_TYPE_UNSTAGE:
                $getDiffCommand = 'git diff --name-status --diff-filter=ACMR';
                break;
            case self::LIST_TYPE_UNTRACKED:
                $getDiffCommand = 'git clean --dry-run | awk \'{print $3;}\'';
                break;
            default:
                throw new InvalidParamException('Invalid list type "' . $listType . '" to extract time!');
        }

        exec($getDiffCommand, $output);

        $files = array_map(function ($v) {
            $file = trim(preg_replace('/^([ACMR]{1})\s{1,}/', '', $v));
            return self::getGitDir() . DIRECTORY_SEPARATOR . $file;
        }, $output);

        return $files;
    }

    /**
     * Extract staged and unstaged files
     *
     * @return array
     */
    public static function extractAllFiles()
    {
        $untrackedFiles = self::extractFiles(self::LIST_TYPE_UNTRACKED);
        $unstagedFiles = self::extractFiles(self::LIST_TYPE_UNSTAGE);
        $stagedFiles = self::extractFiles(self::LIST_TYPE_STAGED);

        $files = array_merge($stagedFiles, $unstagedFiles, $untrackedFiles);

        return $files;
    }
}
