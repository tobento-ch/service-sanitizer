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

use Exception;
use Throwable;

/**
 * FilterNotFoundException
 */
class FilterNotFoundException extends Exception
{
    /**
     * Create a new FilterNotFoundException
     *
     * @param string $filter The filter
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string $filter,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Get the filter.
     *
     * @return string
     */
    public function filter(): string
    {
        return $this->filter;
    }     
}