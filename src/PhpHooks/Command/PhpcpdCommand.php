<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use PhpHooks\Factory\ProcessBuilderFactory;
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
        /* @var $configuration Configuration */
        $configuration = unserialize($input->getArgument('configuration'));

        /** @var ProcessBuilder $processBuilder */
        $processBuilder = ProcessBuilderFactory::createByConfigurationAndCommand(
            $configuration,
            __DIR__ . '/../../../bin/phpcpd'
        );

        if (!empty($configuration['phpcpd']['exclude']) && is_array($configuration['phpcpd']['exclude'])) {
            foreach ($configuration['phpcpd']['exclude'] as $exclude) {
                $processBuilder->add('--exclude');
                $processBuilder->add($exclude);
            }
        }

        $files = unserialize($input->getArgument('files'));

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder->add(dirname($file));

            $this->doExecute($processBuilder);
        }
    }
}
