<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use PhpHooks\Factory\ProcessBuilderFactory;
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
        /** @var Configuration $configuration */
        $configuration = unserialize($input->getArgument('configuration'));
        $files = unserialize($input->getArgument('files'));

        /** @var ProcessBuilder $processBuilder */
        $processBuilder = ProcessBuilderFactory::createByConfigurationAndCommand(
            $configuration,
            __DIR__ . '/../../../bin/phpcs'
        );

        $processBuilder->add(sprintf('--standard=%s', $configuration['phpcs']['standard']));

        if (!empty($configuration['phpcs']['exclude'])) {
            $processBuilder->add(sprintf('--ignore=%s', $configuration['phpcs']['exclude']));
        }

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder->add($file);
            $this->doExecute($processBuilder);
        }
    }
}
