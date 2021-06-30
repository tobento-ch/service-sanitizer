<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Sanitizer\Filter;

use Tobento\Service\Sanitizer\FilterInterface;
use Tobento\Service\Sanitizer\FilterException;

/**
 * Cast value to the given type
 */
class Cast implements FilterInterface
{
    /**
     * Cast value to the given type
     * 
     * @param mixed $value The value to sanitize
     * @param array $parameters The parameters set on the sanitation 'filter:foo:bar'
     *
     * @throws FilterException If filter cannot handle sanitation
     *
     * @return mixed The sanitized value
     */
    public function apply(mixed $value, array $parameters = []): mixed
    {                
        $type = $parameters[0] ?? '';

        // apply default value if null.
        if (is_null($value))
        {
            $value = $parameters[1] ?? null;
        }        
        
        $defaultValue = $this->convert($type, $parameters[1] ?? null);
        
        return $this->convert($type, $value, $defaultValue);      
    }

    /**
     * Convert value to the given type.
     *
     * @param string $type The data type
     * @param mixed $value Any value.
     * @param mixed $default The default data.
     * @return mixed
     */    
    protected function convert(string $type, mixed $value, mixed $default = null): mixed
    {        
        switch ($type) {
            case 'int':
                return is_numeric($value) ? (int) $value : (int) $default;
            case 'float':
                return is_numeric($value) ? (float) $value : (float) $default;
            case 'string':
                return is_scalar($value) ? (string) $value : (string) $default;
            case 'bool':
                return is_scalar($value) ? (bool) $value : (bool) $default;
            case 'array':                
                return $this->toArray($value, $default);
            default:
                throw new FilterException(
                    __CLASS__,
                    "Unsupported sanitizer casting format: {$type}."
                );
        }       
    }
    
    /**
     * Cast to array.
     *
     * @param mixed $data Any data.
     * @param mixed $default The default data.
     * @return array
     */    
    protected function toArray(mixed $data, mixed $default = []): array
    {
        switch (gettype($data))
        {
            case 'array':
                return $data;
            case 'string':
                $data = json_decode($data, true);
                return is_array($data) ? $data : $this->toArray($default);
        }
        
        return $this->toArray($default);
    }
}