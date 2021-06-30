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

/**
 * ParsedFilter
 */
class ParsedFilter
{
    /**
     * Create a new ParsedFilter
     * 
     * @param string $key The filter key such as 'trim'.
     * @param array $parameters The filters parameters if any.
     */
    public function __construct(
        private string $key,
        private array $parameters = [],
    ) {
    }
    
    /**
     * Get the filter key.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get the filter parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return $this->parameters;
    }    
}