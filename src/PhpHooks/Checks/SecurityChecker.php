<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class SecurityChecker
 *
 * @package PhpHooks\Checks
 */
class SecurityChecker extends AbstractCheck
{
    /**
     * @param string $file
     */
    public static function execute($file)
    {
        $processBuilder = new ProcessBuilder();

        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/security-checker')
            ->add('security:check')
            ->add($file);

        self::run($processBuilder);
    }
}