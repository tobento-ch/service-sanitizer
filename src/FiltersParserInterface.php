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
 * FiltersParserInterface
 */
interface FiltersParserInterface
{
    /**
     * Parses the filters.
     * 
     * @param string|array $filters
     * @return array The parsed filters [ParsedFilter, ...]
     */
    public function parse(string|array $filters): array;
}