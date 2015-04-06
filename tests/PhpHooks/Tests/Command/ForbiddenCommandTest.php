<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\ForbiddenCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class ForbiddenCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\ForbiddenCommand
 * @package PhpHooks\Tests\Command
 */
class ForbiddenCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/Debug.php';

        $input = $this->input;
        $input->setArgument('files', serialize([$invalidFile]));

        $command = new ForbiddenCommand();

        $this->setExpectedException(
            'RuntimeException',
            'Forbidden method "var_dump" found in file "' . $invalidFile . '"!'
        );

        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     */
    public function testRunWithoutInvalidFile()
    {
        $this->runWithoutPhpFiles(new ForbiddenCommand());
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new ForbiddenCommand();
        $this->assertEquals('forbidden', $command->getName());
    }
}