<?php

namespace PhpHooks;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PhpHooks\Command;

/**
 * Class Application
 *
 * @package PhpHooks
 */
class Application extends BaseApplication
{
    /**
     * @var string
     */
    private static $logo = '
  ____  _           _   _             _
 |  _ \| |__  _ __ | | | | ___   ___ | | _____
 | |_) | |_ \| |_ \| |_| |/ _ \ / _ \| |/ / __|
 |  __/| | | | |_) |  _  | (_) | (_) |   <\__ \
 |_|   |_| |_| .__/|_| |_|\___/ \___/|_|\_\___/
             |_|                               ';

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var \Symfony\Component\Console\Helper\FormatterHelper
     */
    protected $formatter;

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'PhpHooks', $version = '1.1')
    {
        parent::__construct($name, $version);
        $this->configuration = new Configuration();
        $this->formatter = $this->getHelperSet()->get('formatter');
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files = [])
    {
        $this->files = $files;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(self::$logo);

        if (0 === count($this->files)) {
            $output->writeln('<info>No files given to check.</info>');
            return 0;
        }

        /* @var $command \Symfony\Component\Console\Command\Command */
        foreach ($this->getDefaultCommands() as $command) {

            if (false === $this->configuration[$command->getName()]['enabled']) {
                continue;
            }

            try {
                $command->run($input, $output);
            } catch (\Exception $e) {
                $formattedBlock = $this->formatter->formatBlock($e->getMessage(), 'error');
                $output->writeln($formattedBlock);

                return 1;
            }
        }

        $output->writeln('<info>Well done!</info>');

        return 0;
    }

    /**
     * @return array
     */
    protected function getDefaultCommands()
    {
        return [
            new Command\PhplintCommand(),
            new Command\PhpcsCommand(),
            new Command\PhpcpdCommand(),
            new Command\PhpmdCommand(),
            new Command\ForbiddenCommand(),
            new Command\SecurityCheckerCommand(),
            new Command\PhpunitCommand()
        ];
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function configureIO(InputInterface $input, OutputInterface $output)
    {
        parent::configureIO($input, $output);

        $input->bind(new InputDefinition([
            new InputArgument('configuration'),
            new InputArgument('files'),
            new InputOption('verbose', '-v', InputOption::VALUE_OPTIONAL, '', true)
        ]));

        $input->setArgument('configuration', serialize($this->configuration));
        $input->setArgument('files', serialize($this->files));
    }
}
