<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
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
    protected function configure()
    {
        $this
            ->setName('phplint');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->setPrefix('php')
            ->add('-l');

        foreach ($input->getArgument('files') as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder->add($file);
            parent::doExecute($processBuilder);
        }
    }
}