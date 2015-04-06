<?php

namespace PhpHooks\Tests\Command;

use PhpHooks\Command\PhpunitCommand;
use PhpHooks\Configuration;
use PhpHooks\Tests\CommandTestCase;

/**
 * Class PhpunitCommandTest
 *
 * @coversDefaultClass \PhpHooks\Command\PhpunitCommand
 * @package PhpHooks\Tests\Command
 */
class PhpunitCommandTest extends CommandTestCase
{
    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRun()
    {
        $configuration = new Configuration();
        $configuration->merge([
            'phpunit' => ['configuration' => realpath(__DIR__ . '/../Fixtures/PhpUnit/phpunit.xml')]
        ]);

        $input = $this->input;
        $input->setArgument('configuration', serialize($configuration));

        $command = new PhpunitCommand();

        $this->setExpectedExceptionRegExp(
            'RuntimeException',
            '/Tests\: 1\, Assertions\: 1\, Failures\: 1\./'
        );

        $command->run($input, $this->output);
    }

    /**
     * @covers ::run
     * @covers \PhpHooks\Abstracts\BaseCommand::doExecute
     */
    public function testRunWithoutConfiguration()
    {
        $command = new PhpunitCommand();
        $command->run($this->input, $this->output);
    }

    /**
     * @covers ::configure
     */
    public function testConfigure()
    {
        $command = new PhpunitCommand();
        $this->assertEquals('phpunit', $command->getName());
    }
}