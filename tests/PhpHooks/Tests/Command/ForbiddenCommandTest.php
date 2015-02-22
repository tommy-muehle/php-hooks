<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\ForbiddenCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class ForbiddenCommandTest
 * @package PhpHooks\Tests\Command
 */
class ForbiddenCommandTest extends CommandTestCase
{
    /**
     * @covers \PhpHooks\Command\ForbiddenCommand::run
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/Debug.php';

        $input = $this->input;
        $input->setArgument('files', [$invalidFile]);

        $command = new ForbiddenCommand();

        $this->setExpectedException(
            'RuntimeException',
            'Forbidden method "var_dump" found in file "' . $invalidFile . '"!'
        );

        $command->run($input, $this->output);
    }
}