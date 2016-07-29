<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use PhpHooks\Factory\ProcessBuilderFactory;
use PhpHooks\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhplintCommand
 *
 * @package Command
 */
class PhplintCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('phplint');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        /* @var $configuration Configuration */
        $configuration = unserialize($input->getArgument('configuration'));

        /** @var ProcessBuilder $processBuilder */
        $processBuilder = ProcessBuilderFactory::createByConfiguration($configuration);

        $processBuilder
            ->add('-l');

        $files = unserialize($input->getArgument('files'));

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder->add($file);
            $this->doExecute($processBuilder);
        }
    }
}
