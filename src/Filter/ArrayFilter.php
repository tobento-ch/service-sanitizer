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
use Tobento\Service\Sanitizer\SanitizerInterface;

/**
 * ArrayFilter
 */
class ArrayFilter implements FilterInterface
{
    /**
     * Create a new ArrayFilter.
     *
     * @param SanitizerInterface $sanitizer
     */
    public function __construct(
        protected SanitizerInterface $sanitizer,
    ) {}
    
    /**
     * ArrayFilter
     * 
     * @param mixed $value The value to sanitize
     * @param array $parameters The parameters set on the sanitation 'date:Y-m-d:Y.m.d'
     *
     * @throws FilterException If filter cannot handle sanitation
     *
     * @return mixed The sanitized value
     */
    public function apply(mixed $value, array $parameters = []): mixed
    {    
        if (!is_array($value))
        {
            return $value;
        }
        
        $filters = $parameters[0] ?? '';
                
        $sanitized = [];
        
        foreach($value as $key => $val)
        {
            if (isset($parameters[1]))
            {
                $key = $this->sanitizer->sanitizing($key, $parameters[1]);
            }
            
            $sanitized[$key] = $this->sanitizer->sanitizing($val, $filters);
        }
        
        return $sanitized;
    }
}