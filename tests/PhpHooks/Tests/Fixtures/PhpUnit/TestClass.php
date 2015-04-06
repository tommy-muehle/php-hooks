<?php

namespace PhpHooks\Tests\Fixtures\PhpUnit;

/**
 * Class TestClass
 * @package PhpHooks\Tests\Fixtures\PhpUnit
 */
class TestClass extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $this->assertFalse(true);
    }
}