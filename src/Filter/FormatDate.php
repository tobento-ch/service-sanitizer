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
use Tobento\Service\Dater\DateFormatter;

/**
 * Format date
 */
class FormatDate implements FilterInterface
{
    /**
     * Format date
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
        
        $currentFormat = $parameters[0] ?? 'd.m.Y';
        $targetFormat  = $parameters[1] ?? 'd.m.Y';
                
        $df = new DateFormatter();
        
        $date = $df->toDateTime($value, null, null, $currentFormat);
        
        if (is_null($date))
        {
            return $value;
        }
        
        return $df->format($date, $targetFormat);
    }
}