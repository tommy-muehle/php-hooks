<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phpmd
 *
 * @package PhpHooks\Checks
 */
class Phpmd extends AbstractCheck
{
    /**
     * @param string $file
     * @param string $ruleset
     *
     * @throws \RuntimeException if a violation exist
     * @return void
     */
    public static function execute($file, $ruleset = 'codesize')
    {
        $processBuilder = new ProcessBuilder();

        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpmd')
            ->setArguments(array($file, 'text', $ruleset));

        self::run($processBuilder);
    }
}