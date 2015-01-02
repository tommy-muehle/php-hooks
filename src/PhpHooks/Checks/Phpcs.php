<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phpcs
 *
 * @package PhpHooks\Checks
 */
class Phpcs
{
    /**
     * @param string $file
     * @param string $standard
     */
    public static function execute($file, $standard = 'PSR1')
    {
        $processBuilder = new ProcessBuilder();

        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpcs')
            ->add(sprintf('--standard=%s', $standard))
            ->add($file);

        $process = $processBuilder->getProcess();
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getOutput()));
        }
    }
}