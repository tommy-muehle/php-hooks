<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpHooks
 */
class PhpHooks extends Application
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
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct('PhpHooks', '1.0');
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files = array())
    {
        $this->files = $files;
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

                $output->writeln($formatter->formatSection('phplint', $file));
                $this->phplint($file);

                $output->writeln($formatter->formatSection('forbidden', $file));
                $this->forbiddenMethods($file);

                $output->writeln($formatter->formatSection('phpmd', $file));
                $this->phpmd($file);
            }

        } catch (\Exception $e) {
            $errorMessages = array('Error!', $e->getMessage());
            $formattedBlock = $formatter->formatBlock($errorMessages, 'error');
            $output->writeln($formattedBlock);
        }
    }

    /**
     * @param string $file
     */
    protected function phplint($file)
    {
        $processBuilder = new ProcessBuilder(array('php', '-l', $file));
        $process = $processBuilder->getProcess();
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getErrorOutput()));
        }
    }

    /**
     * @param string $file
     */
    protected function forbiddenMethods($file)
    {
        $forbiddenMethods = array('/die\(/', '/var_dump\(/', '/print_r\(/');
        $content = file_get_contents($file);

        foreach ($forbiddenMethods as $methodPattern) {
            preg_match($methodPattern, $content, $matches);

            if (count($matches) > 0) {
                throw new \RuntimeException(sprintf(
                    'Forbidden method "%s" found in file "%s"!', $matches[0], $file
                ));
            }
        }
    }

    /**
     * @param string $file
     */
    protected function phpmd($file)
    {
        $processBuilder = new ProcessBuilder();

        $processBuilder
            ->setPrefix(__DIR__ . '/bin/phpmd')
            ->setArguments(array($file, 'text', 'codesize'));

        $process = $processBuilder->getProcess();
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getOutput()));
        }
    }
}