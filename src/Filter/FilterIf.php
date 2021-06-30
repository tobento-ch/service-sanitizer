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
use Tobento\Service\Collection\Collection;

/**
 * Apply filters only if a value matches the given condition.
 */
class FilterIf implements FilterInterface
{    
    /**
     * Apply filters only if a value matches the given condition.
     * 
     * @param mixed $value The value to sanitize
     * @param array $parameters The parameters set on the sanitation 'filter:foo:bar'
     *
     * @throws FilterException If filter cannot handle sanitation
     *
     * @return mixed Return true if to apply filters, otherwise false.
     */
    public function apply(mixed $value, array $parameters = []): mixed
    {
        [$value, $data] = $value;
        
        if (! $data instanceof Collection)
        {
            return false;
        }
        
        if (count($parameters) < 2)
        {
            return false;
        }
        
        if (! $data->has($parameters[0]))
        {
            return false;
        }
        
        return $data->get($parameters[0]) === $parameters[1];
    }
}