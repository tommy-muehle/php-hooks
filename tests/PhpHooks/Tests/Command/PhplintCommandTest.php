<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\PhplintCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class PhplintCommandTest
 * @package PhpHooks\Tests\Command
 */
class PhplintCommandTest extends CommandTestCase
{
    /**
     * @covers \PhpHooks\Command\PhplintCommand::run
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/Invalid.php';

        $input = $this->input;
        $input->setArgument('files', [$invalidFile]);

        $command = new PhplintCommand();

        $this->setExpectedException(
            'RuntimeException',
            'PHP Parse error:  syntax error, unexpected end of file, expecting \',\' or \';\' in ' . $invalidFile . ' on line 3'
        );

        $command->run($input, $this->output);
    }
}