<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phpunit
 *
 * @package PhpHooks\Checks
 */
class Phpunit extends AbstractCheck
{
    /**
     * @param string $configuration
     *
     * @throws \RuntimeException if a violation exist
     * @return void
     */
    public static function execute($configuration = null)
    {
        if (false === file_exists($configuration)) {
            throw new \RuntimeException('Configuration for phpunit not found!');
        }

        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpunit')
            ->setArguments(array('--configuration', $configuration));

        self::run($processBuilder);
    }
}