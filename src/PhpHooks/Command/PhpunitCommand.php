<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use PhpHooks\Factory\ProcessBuilderFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpunitCommand
 *
 * @package PhpHooks\Command
 */
class PhpunitCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('phpunit');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        /* @var $configuration \PhpHooks\Configuration */
        $configuration = unserialize($input->getArgument('configuration'));

        if (false === file_exists($configuration['phpunit']['configuration'])) {
            return;
        }

        /** @var ProcessBuilder $processBuilder */
        $processBuilder = ProcessBuilderFactory::createByConfigurationAndCommand(
            $configuration,
            __DIR__ . '/../../../bin/phpunit'
        );

        $processBuilder
            ->add('--configuration')
            ->add($configuration['phpunit']['configuration']);

        $this->doExecute($processBuilder);
    }
}
