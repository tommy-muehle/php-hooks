<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class SecurityCheckerCommand
 *
 * @package PhpHooks\Command
 */
class SecurityCheckerCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('security-checker');
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
            ->setPrefix(__DIR__ . '/../../../bin/security-checker')
            ->add('security:check');

        foreach ($input->getArgument('files') as $file) {
            if (substr($file, -13, 13) !== 'composer.lock') {
                continue;
            }

            $processBuilder->add($file);
            parent::doExecute($processBuilder);
        }
    }
}