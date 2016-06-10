<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use PhpHooks\Configuration;
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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        /* @var $configuration Configuration */
        $configuration = unserialize($input->getArgument('configuration'));

        $files = unserialize($input->getArgument('files'));

        $commandPath = $this->getCommandPathByConfiguration($configuration);

        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->setPrefix($commandPath);

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php') {
                continue;
            }

            $processBuilder
                ->add($file)
                ->add('text')
                ->add(preg_replace('/\s+/', null, $configuration['phpmd']['ruleset']));

            if (!empty($configuration['phpmd']['exclude'])) {
                $processBuilder->add('--exclude');
                $processBuilder->add(sprintf('%s', $configuration['phpmd']['exclude']));
            }

            $this->doExecute($processBuilder);
        }
    }

    /**
     * @param array $configuration
     * @return bool
     */
    protected function isConfigurationFileExists($configuration)
    {
        return isset($configuration['phpmd']['configuration']) && is_readable($configuration['phpmd']['configuration']);
    }

    /**
     * @param Configuration $configuration
     * @return string
     */
    protected function getCommandPathByConfiguration($configuration)
    {
        if (empty($configuration['phpmd']['command']) || !is_executable($configuration['phpmd']['command'])) {
            return __DIR__ . '/../../../bin/phpmd';
        }

        return $configuration['phpmd']['command'];
    }
}
