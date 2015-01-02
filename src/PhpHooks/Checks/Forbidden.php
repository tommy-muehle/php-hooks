<?php

namespace PhpHooks\Checks;

/**
 * Class Forbidden
 *
 * @package PhpHooks\Checks
 */
class Forbidden
{
    /**
     * @param string $file
     * @param array  $methods
     */
    public static function execute($file, array $methods = array())
    {
        $content = file_get_contents($file);

        foreach ($methods as $method) {
            $methodPattern = sprintf('/^%s\((.*)\);$/', $method);
            preg_match($methodPattern, $content, $matches);

            if (count($matches) === 0) {
                continue;
            }

            $message = sprintf('Forbidden method "%s" found in file "%s"!', $matches[0], $file);
            throw new \RuntimeException($message);
        }
    }
}