<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpcpdCommand
 *
 * @package Command
 */
class PhpcpdCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('phpcpd');
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
            ->setPrefix(__DIR__ . '/../../../bin/phpcpd');

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
