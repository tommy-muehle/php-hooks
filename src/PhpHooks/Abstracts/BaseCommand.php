<?php

namespace PhpHooks\Abstracts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class BaseCommand
 *
 * @package PhpHooks\Abstracts
 */
abstract class BaseCommand extends Command
{
    /**
     * @param ProcessBuilder $processBuilder
     */
    public function doExecute(ProcessBuilder $processBuilder)
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