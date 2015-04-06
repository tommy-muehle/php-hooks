<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\PhpcpdCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class PhpcpdCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\PhpcpdCommand
 * @package PhpHooks\Tests\Command
 */
class PhpcpdCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/Duplicated.php';

        $input = $this->input;
        $input->setArgument('files', serialize([$invalidFile]));

        $command = new PhpcpdCommand();

        $this->setExpectedExceptionRegExp(
            'RuntimeException',
            '/43\.70\% duplicated lines out of 135 total lines of code/'
        );

        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     */
    public function testRunWithoutPhpFiles()
    {
        $this->runWithoutPhpFiles(new PhpcpdCommand());
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new PhpcpdCommand();
        $this->assertEquals('phpcpd', $command->getName());
    }
}