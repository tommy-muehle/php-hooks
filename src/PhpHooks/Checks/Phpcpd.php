<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phpcpd
 *
 * @package PhpHooks\Checks
 */
class Phpcpd
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

        $process = $processBuilder->getProcess();
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getErrorOutput()));
        }
    }
}