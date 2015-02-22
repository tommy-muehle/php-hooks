<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpcsCommand
 *
 * @package PhpHooks\Command
 */
class PhpcsCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('phpcs');
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
        $configuration = $input->getArgument('configuration');

        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpcs')
            ->add(sprintf('--standard=%s', $configuration['phpcs']['standard']));

        foreach ($input->getArgument('files') as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder->add($file);
            parent::doExecute($processBuilder);
        }
    }
}