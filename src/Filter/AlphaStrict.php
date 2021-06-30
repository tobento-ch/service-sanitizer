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
 * AlphaStrict
 */
class AlphaStrict implements FilterInterface
{
    /**
     * AlphaStrict
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
        if (!is_string($value))
        {
            return $value;
        }
        
        return preg_replace('/[^a-zA-Z]/', '', $value);
    }
}