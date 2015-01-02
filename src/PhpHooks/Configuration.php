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
    protected $configuration = array(
        'phpmd' => array(
            'ruleset' => 'codesize'
        ),
        'phpcs' => array(
            'standard' => 'PSR1'
        ),
        'forbidden' => array(
            'methods' => array()
        )
    );

    /**
     * @param array $fileConfiguration
     *
     * @return array
     */
    public function merge(array $fileConfiguration = array())
    {
        $this->configuration = $this->mergeConfigurationArrays(
            $this->configuration, $fileConfiguration
        );
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
        // TODO: Implement offsetSet() method.
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}