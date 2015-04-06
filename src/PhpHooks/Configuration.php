<?php

namespace PhpHooks;

/**
 * Class Configuration
 *
 * @package PhpHooks
 */
class Configuration implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $configuration = [
        'phplint' => [
            'enabled' => true
        ],
        'phpmd' => [
            'enabled' => true,
            'ruleset' => 'codesize'
        ],
        'phpcs' => [
            'enabled' => true,
            'standard' => 'PSR2'
        ],
        'phpcpd' => [
            'enabled' => true
        ],
        'forbidden' => [
            'enabled' => true,
            'methods' => ['var_dump', 'print_r', 'die']
        ],
        'phpunit' => [
            'enabled' => true,
            'configuration' => null
        ],
        'security-checker' => [
            'enabled' => true
        ]
    ];

    /**
     * @param array $configuration
     *
     * @return array
     */
    public function merge(array $configuration = [])
    {
        $this->configuration = $this->mergeConfigurationArrays(
            $this->configuration, $configuration
        );
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->configuration[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (true === $this->offsetExists($offset)) {
            return $this->configuration[$offset];
        }

        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->configuration[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if (isset($this->configuration[$offset])) {
            unset($this->configuration[$offset]);
        }
    }

    /**
     * @param array $configuration
     * @param array $newConfiguration
     *
     * @return array
     */
    protected function mergeConfigurationArrays(array $configuration, array $newConfiguration)
    {
        foreach ($newConfiguration as $key => $value) {
            if (array_key_exists($key, $configuration) && is_array($value)) {
                $configuration[$key] = $this->mergeConfigurationArrays($configuration[$key], $newConfiguration[$key]);
            } else {
                $configuration[$key] = $value;
            }
        }

        return $configuration;
    }
}