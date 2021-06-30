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

namespace Tobento\Service\Sanitizer;

use InvalidArgumentException;

/**
 * FiltersParser
 */
class FiltersParser implements FiltersParserInterface
{
    /**
     * Parses the filters.
     * 
     * @param string|array $filters
     * @return array The parsed filters [ParsedFilter, ...]
     */
    public function parse(string|array $filters): array
    {
        if (is_string($filters))
        {
            return $this->parseFiltersString($filters);
        }

        $parsed = [];

        foreach($filters as $filter => $params)
        {
            // Flip $filter with $params if $filter is an int. 
            //['filter', 'anotherFilter' => []] -> ['filter' => [], 'anotherFilter' => []]
            // We need it do it this way, as to keep order.
            if (is_int($filter))
            {
                if (!is_string($params))
                {
                    throw new InvalidArgumentException(
                        'Sanitizer filter is invalid. The filter needs to be a string, "'.gettype($params).'" given.'
                    );                        
                }

                $parsed[] = new ParsedFilter($params);
            }
            else
            {
                if (!is_array($params))
                {
                    $params = [];
                }

                $parsed[] = new ParsedFilter($filter, $params);
            }
        }

        return $parsed;    
    }    

    /**
     * Parses the filters from string to an array
     * 
     * @param string $filters
     * @return array [[filter, [...]]]
     */
    protected function parseFiltersString(string $filters): array
    {
        if (empty($filters)) {
            return [];
        }
        
        $parsed = [];
        
        foreach(explode('|', $filters) as $filter)
        {
            if (str_contains($filter, ':'))
            {
                $params = explode(':', $filter);
                $filter = array_shift($params);

                $parsed[] = new ParsedFilter($filter, $params);
            }
            else
            {
                $parsed[] = new ParsedFilter($filter);
            }        
        }
        
        return $parsed;
    }
}