<?php

namespace PhpHooks\Command;

use PhpHooks\Abstracts\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ForbiddenCommand
 *
 * @package PhpHooks\Command
 */
class ForbiddenCommand extends BaseCommand
{
    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setName('forbidden');
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

        foreach ($files as $file) {
            foreach ($configuration['forbidden']['methods'] as $method) {

                $pattern = $method . '(';
                $content = file_get_contents($file);

                if (false === strpos($content, $pattern)) {
                    continue;
                }

                throw new \RuntimeException(
                    sprintf('Forbidden method "%s" found in file "%s"!', $method, $file)
                );
            }
        }
    }
}
