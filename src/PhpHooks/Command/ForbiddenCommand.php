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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        /** @var Configuration $configuration */
        $configuration = unserialize($input->getArgument('configuration'));
        $files = unserialize($input->getArgument('files'));

        foreach ($files as $file) {
            if (substr($file, -4, 4) !== '.php' || $this->checkExcludeFile($file, $configuration['forbidden'])) {
                continue;
            }

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

    /**
     * @param string $filePath
     * @param array $configuration
     * @return bool
     */
    protected function checkExcludeFile($filePath, array $configuration)
    {
        if (empty($configuration['exclude']) || !is_array($configuration['exclude'])) {
            return false;
        }

        $currentFileName = basename($filePath);
        foreach ($configuration['exclude'] as $fileName) {
            if ($currentFileName === $fileName) {
                return true;
            }
        }

        return false;
    }
}
