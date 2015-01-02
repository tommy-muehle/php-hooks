<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phpcpd
 *
 * @package PhpHooks\Checks
 */
class Phpcpd extends AbstractCheck
{
    /**
     * @param string $file
     */
    public static function execute($file)
    {
        $processBuilder = new ProcessBuilder();

        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpcpd')
            ->setArguments(array($file));

        self::run($processBuilder);
    }
}