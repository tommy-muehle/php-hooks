<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\PhpmdCommand;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class PhpmdCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\PhpmdCommand
 * @package PhpHooks\Tests\Command
 */
class PhpmdCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $invalidFile = __DIR__ . '/../Fixtures/LargeMethod.php';

        $input = $this->input;
        $input->setArgument('files', serialize([$invalidFile]));

        $command = new PhpmdCommand();

        $this->setExpectedException(
            'RuntimeException',
            'The method example() has a Cyclomatic Complexity of 11. The configured cyclomatic complexity threshold is 10.'
        );

        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     */
    public function testRunWithoutPhpFiles()
    {
        $this->runWithoutPhpFiles(new PhpmdCommand());
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new PhpmdCommand();
        $this->assertEquals('phpmd', $command->getName());
    }
}