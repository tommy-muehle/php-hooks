<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpmdCommand
 *
 * @package PhpHooks\Command
 */
class PhpmdCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('phpmd');
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
        $files = unserialize($input->getArgument('files'));

        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->setPrefix(__DIR__ . '/../../../bin/phpmd');

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder
                ->add($file)
                ->add('text')
                ->add($configuration['phpmd']['ruleset']);

            $this->doExecute($processBuilder);
        }
    }
}