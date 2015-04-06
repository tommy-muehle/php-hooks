<?php

namespace PhpHooks\Tests;

use PhpHooks\Application;
use PhpHooks\Configuration;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class ApplicationTest
 *
 * @coversDefaultClass \PhpHooks\Application
 * @package PhpHooks\Tests
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $app;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = new Application();
    }

    /**
     * @covers ::__construct
     */
    public function testDefaultsAreSet()
    {
        $class = new \ReflectionClass(get_class($this->app));

        $configuration = $class->getProperty('configuration');
        $configuration->setAccessible(true);

        $formatter = $class->getProperty('formatter');
        $formatter->setAccessible(true);

        $this->assertInstanceOf('PhpHooks\Configuration', $configuration->getValue($this->app));
        $this->assertInstanceOf('Symfony\Component\Console\Helper\FormatterHelper', $formatter->getValue($this->app));
        $this->assertEquals('PhpHooks', $this->app->getName());
        $this->assertEquals('1.1', $this->app->getVersion());
    }

    /**
     * @covers ::setFiles
     * @covers ::getFiles
     */
    public function testCanSetAndGetFiles()
    {
        $files = [
            __DIR__ . '/Fixtures/Debug.php',
            __DIR__ . '/Fixtures/Invalid.php'
        ];

        $this->assertCount(0, $this->app->getFiles());
        $this->app->setFiles($files);
        $this->assertCount(2, $this->app->getFiles());
    }

    /**
     * @covers ::getConfiguration
     * @covers ::setConfiguration
     */
    public function testCanSetAndGetConfiguration()
    {
        $newConfiguration = new Configuration();
        $newConfiguration->merge([
            'phpunit' => ['enabled' => false]
        ]);

        $this->app->setConfiguration($newConfiguration);

        $configuration = $this->app->getConfiguration();
        $this->assertFalse($configuration['phpunit']['enabled']);
    }

    /**
     * @covers ::getDefaultCommands
     */
    public function testGetDefaultCommands()
    {
        $reflection = new \ReflectionClass(get_class($this->app));

        $method = $reflection->getMethod('getDefaultCommands');
        $method->setAccessible(true);

        $result = $method->invoke($this->app);

        $this->assertTrue(is_array($result));
        $this->assertCount(7, $result);
    }

    /**
     * @covers ::doRun
     */
    public function testDoRunWithoutFiles()
    {
        $output = new ConsoleOutput();
        $input  = new ArrayInput([]);

        $this->assertEquals(0, $this->app->doRun($input, $output));
    }

    /**
     * @covers ::doRun
     * @covers ::configureIO
     */
    public function testDoRunWithoutPhpFiles()
    {
        $files = [__DIR__ . '/Fixtures/text.txt'];
        $this->app->setFiles($files);

        $output = new ConsoleOutput();
        $input  = new ArrayInput([]);

        $reflection = new \ReflectionClass(get_class($this->app));

        $method = $reflection->getMethod('configureIO');
        $method->setAccessible(true);
        $method->invokeArgs($this->app, [$input, $output]);

        $this->assertEquals(0, $this->app->doRun($input, $output));
    }

    /**
     * @covers ::doRun
     * @covers ::configureIO
     */
    public function testDoRunWithInvalidPhpFiles()
    {
        $files = [__DIR__ . '/Fixtures/Invalid.php'];
        $this->app->setFiles($files);

        $output = new ConsoleOutput();
        $input  = new ArrayInput([]);

        $reflection = new \ReflectionClass(get_class($this->app));

        $method = $reflection->getMethod('configureIO');
        $method->setAccessible(true);
        $method->invokeArgs($this->app, [$input, $output]);

        $this->assertEquals(1, $this->app->doRun($input, $output));
    }

    /**
     * @covers ::doRun
     * @covers ::configureIO
     */
    public function testDoRunWithInvalidPhpFilesAndOneDisabledCheck()
    {
        $files = [__DIR__ . '/Fixtures/Invalid.php'];
        $this->app->setFiles($files);

        $this->app->getConfiguration()->merge(['phplint' => ['enabled' => false]]);

        $output = new ConsoleOutput();
        $input  = new ArrayInput([]);

        $reflection = new \ReflectionClass(get_class($this->app));

        $method = $reflection->getMethod('configureIO');
        $method->setAccessible(true);
        $method->invokeArgs($this->app, [$input, $output]);

        $this->assertEquals(1, $this->app->doRun($input, $output));
    }

    /**
     * @covers ::configureIO
     */
    public function testConfigureIO()
    {
        $reflection = new \ReflectionClass(get_class($this->app));

        $method = $reflection->getMethod('configureIO');
        $method->setAccessible(true);

        $output = new ConsoleOutput();
        $input  = new ArrayInput([
            'configuration' => serialize(new Configuration()),
            'files' => serialize([])
        ]);

        $method->invokeArgs($this->app, [$input, $output]);

        $this->assertTrue($input->hasArgument('configuration'));
        $this->assertTrue($input->hasArgument('files'));
        $this->assertTrue($input->hasOption('verbose'));
    }
}