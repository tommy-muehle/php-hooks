<?php

namespace PhpHooks\Tests;

use PhpHooks\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class CommandTestCase
 * @package PhpHooks\Tests
 */
abstract class CommandTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Console\Input\ArrayInput
     */
    protected $input;

    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    protected $output;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $definition = new InputDefinition([
            new InputArgument('configuration'),
            new InputArgument('files')
        ]);

        $this->output = new ConsoleOutput();
        $this->input  = new ArrayInput(
            ['configuration' => serialize(new Configuration())],
            $definition
        );
    }

    /**
     * @param Command $command
     */
    protected function runWithoutPhpFiles(Command $command)
    {
        $input = $this->input;
        $input->setArgument('files', serialize([__DIR__ . '/Fixtures/text.txt']));

        $command->run($input, $this->output);
    }
}