<?php

namespace PhpHooks\Tests;

use PhpHooks\Configuration;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class CommandTestCase
 * @package PhpHooks\Tests
 */
class CommandTestCase extends \PHPUnit_Framework_TestCase
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

        $this->output = new ConsoleOutput();
        $this->input  = new ArrayInput(
            ['configuration' => new Configuration()],
            new InputDefinition([
                new InputArgument('configuration'),
                new InputArgument('files')
            ])
        );
    }
}