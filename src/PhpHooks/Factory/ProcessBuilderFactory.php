<?php

namespace PhpHooks\Factory;

use PhpHooks\Configuration;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class ProcessBuilderFactory
 *
 * @package PhpHooks\Factory
 */
class ProcessBuilderFactory
{
    const DEFAULT_PHP_BINARY = 'php';

    /**
     * @param Configuration $configuration
     * @param string        $command
     *
     * @return ProcessBuilder
     */
    public static function createByConfigurationAndCommand(Configuration $configuration, $command)
    {
        $processBuilder = new ProcessBuilder();

        if (isset($configuration['environment']['php_binary'])) {
            return $processBuilder
                ->setPrefix($configuration['environment']['php_binary'])
                ->add($command);
        }

        return $processBuilder->setPrefix($command);
    }

    /**
     * @param Configuration $configuration
     *
     * @return ProcessBuilder
     */
    public static function createByConfiguration(Configuration $configuration)
    {
        $processBuilder = new ProcessBuilder();

        if (isset($configuration['environment']['php_binary'])) {
            return $processBuilder->setPrefix($configuration['environment']['php_binary']);
        }

        return $processBuilder->setPrefix(self::DEFAULT_PHP_BINARY);
    }
}
