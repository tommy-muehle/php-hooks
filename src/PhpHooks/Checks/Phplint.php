<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phplint
 *
 * @package PhpHooks\Checks
 */
class Phplint
{
    /**
     * @param string $file
     */
    public static function execute($file)
    {
        $processBuilder = new ProcessBuilder(array('php', '-l', $file));
        $process = $processBuilder->getProcess();
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getErrorOutput()));
        }
    }
}