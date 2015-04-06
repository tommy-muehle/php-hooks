<?php

namespace PhpHooks\Tests;

use PhpHooks\Configuration;

/**
 * Class ConfigurationTest
 *
 * @coversDefaultClass \PhpHooks\Configuration
 * @package PhpHooks\Tests
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::merge
     * @covers ::mergeConfigurationArrays
     */
    public function testMerge()
    {
        $configuration = new Configuration();
        $this->assertTrue($configuration['phpunit']['enabled']);

        $configuration->merge([
            'phpunit' => ['enabled' => false]
        ]);

        $this->assertFalse($configuration['phpunit']['enabled']);
    }

    /**
     * @covers ::offsetExists
     */
    public function testOffsetExists()
    {
        $configuration = new Configuration();
        $this->assertTrue($configuration->offsetExists('phpunit'));
    }

    /**
     * @covers ::offsetGet
     */
    public function testOffsetGet()
    {
        $configuration = new Configuration();
        $options = $configuration->offsetGet('phpunit');

        $this->assertTrue(is_array($options));
        $this->arrayHasKey('enabled', $options);
        $this->assertNull($configuration->offsetGet('invalid'));
    }

    /**
     * @covers ::offsetSet
     */
    public function testOffsetSet()
    {
        $configuration = new Configuration();

        $this->assertNull($configuration->offsetGet('new'));
        $configuration->offsetSet('new', 'value');
        $this->assertEquals('value', $configuration->offsetGet('new'));
    }

    /**
     * @covers ::offsetUnset
     */
    public function testOffsetUnset()
    {
        $configuration = new Configuration();

        $this->assertNotNull($configuration->offsetGet('phpunit'));
        $configuration->offsetUnset('phpunit');
        $this->assertNull($configuration->offsetGet('phpunit'));
    }
}