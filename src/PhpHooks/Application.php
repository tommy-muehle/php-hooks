<?php

namespace PhpHooks;

use PhpHooks\Checks\Forbidden;
use PhpHooks\Checks\Phpcpd;
use PhpHooks\Checks\Phpcs;
use PhpHooks\Checks\Phplint;
use PhpHooks\Checks\Phpmd;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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
    protected $files = array();

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'PhpHooks', $version = '1.0')
    {
        parent::__construct($name, $version);
        $this->configuration = new Configuration();
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files = array())
    {
        $this->files = $files;
    }

    /**
     * @param string $file
     */
    public function updateConfiguration($file)
    {
        $configuration = Yaml::parse($file);
        $this->configuration->merge($configuration);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(self::$logo);

        /* @var $formatter \Symfony\Component\Console\Helper\FormatterHelper */
        $formatter = $this->getHelperSet()->get('formatter');

        try {
            /* @var string $file */
            foreach ($this->files as $file) {

                if (substr($file, -4, 4) !== '.php') {
                    continue;
                }

                $output->writeln($formatter->formatSection('forbidden', $file));
                Forbidden::execute($file, $this->configuration['forbidden']['methods']);

                $output->writeln($formatter->formatSection('phplint', $file));
                Phplint::execute($file);

                $output->writeln($formatter->formatSection('phpmd', $file));
                Phpmd::execute($file, $this->configuration['phpmd']['ruleset']);

                $output->writeln($formatter->formatSection('phpcs', $file));
                Phpcs::execute($file, $this->configuration['phpcs']['standard']);

                $output->writeln($formatter->formatSection('phpcpd', $file));
                Phpcpd::execute($file);
            }

            exit(0);

        } catch (\Exception $e) {
            $errorMessages = array('Error!', $e->getMessage());
            $formattedBlock = $formatter->formatBlock($errorMessages, 'error');
            $output->writeln($formattedBlock);

            exit(1);
        }
    }
}