<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Tests\CommandTestCase;
use PhpHooks\Command\SecurityCheckerCommand;

/**
 * Class SecurityCheckerCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\SecurityCheckerCommand
 * @package PhpHooks\Tests\Command
 */
class SecurityCheckerCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $input = $this->input;
        $input->setArgument('files', serialize([__DIR__ . '/../../../../composer.lock']));

        $command = new SecurityCheckerCommand();
        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRunWithoutLockFile()
    {
        $input = $this->input;
        $input->setArgument('files', serialize([__DIR__ . '/../Fixtures/text.txt']));

        $command = new SecurityCheckerCommand();
        $command->run($input, $this->output);
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new SecurityCheckerCommand();
        $this->assertEquals('security-checker', $command->getName());
    }
}