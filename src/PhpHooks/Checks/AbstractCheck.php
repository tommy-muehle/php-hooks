<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class AbstractCheck
 *
 * @package PhpHooks\Checks
 */
abstract class AbstractCheck
{
    /**
     * @param ProcessBuilder $processBuilder
     */
    public static function run(ProcessBuilder $processBuilder)
    {
        $process = $processBuilder->getProcess();
        $process->run();

        if (true === $process->isSuccessful()) {
            return;
        }

        $errorMsg = trim($process->getErrorOutput());

        if (empty($errorMsg)) {
            $errorMsg = $process->getOutput();
        }

        throw new \RuntimeException($errorMsg);
    }
}