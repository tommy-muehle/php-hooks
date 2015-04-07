<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\PhpcsCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class PhpcsCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\PhpcsCommand
 * @package PhpHooks\Tests\Command
 */
class PhpcsCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/Unformated.php';

        $input = $this->input;
        $input->setArgument('files', serialize([$invalidFile]));

        $command = new PhpcsCommand();

        $this->setExpectedExceptionRegExp(
            'RuntimeException',
            '/FOUND 5 ERRORS AFFECTING 4 LINES/'
        );

        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     */
    public function testRunWithoutPhpFiles()
    {
        $this->runWithoutPhpFiles(new PhpcsCommand());
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new PhpcsCommand();
        $this->assertEquals('phpcs', $command->getName());
    }
}