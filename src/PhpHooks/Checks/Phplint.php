<?php

namespace PhpHooks\Checks;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Phplint
 *
 * @package PhpHooks\Checks
 */
class Phplint extends AbstractCheck
{
    /**
     * @param string $file
     */
    public static function execute($file)
    {
        self::run(new ProcessBuilder(array('php', '-l', $file)));
    }
}