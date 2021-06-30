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
 * The SanitizerInterface
 */
interface SanitizerInterface
{
    /**
     * Add a filter.
     * 
     * @param string $key The filter key such as 'stripTags'.
     * @param callable|FilterInterface $filter The filter.
     * @return static $this
     */
    public function addFilter(string $key, callable|FilterInterface $filter): static;

    /**
     * Sanitizes a value with the given filters.
     * 
     * @param mixed $value The value
     * @param string|array $filters The filters 'stripTags|ucwords' or ['date' => ['Y-m-d', 'Y.m.d H:i']]
     *
     * @throws FilterException If filter cannot handle sanitation
     * @throws FilterNotFoundException
     *
     * @return mixed The sanitized value
     */
    public function sanitizing(mixed $value, string|array $filters): mixed;
    
    /**
     * Sanitizes the data given.
     * 
     * @param mixed $data The data.
     * @param array $sanitation The filters index by the data key ['title' => 'stripTags|ucwords']
     * @param bool $strictSanitation If true, sanitizes missing data too, otherwise not.
     * @param bool $returnSanitizedOnly If true, returns only the sanitized data, otherwise all.
     *
     * @throws FilterException If filter cannot handle sanitation
     * @throws FilterNotFoundException
     *
     * @return array The data sanitized
     */
    public function sanitize(
        mixed $data,
        array $sanitation,
        bool $strictSanitation = false,
        bool $returnSanitizedOnly = false,
    ): array;
}