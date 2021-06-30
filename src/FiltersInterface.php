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
 * FilterInterface
 */
interface FiltersInterface
{
    /**
     * Add the filters to the sanitizer.
     *
     * @param SanitizerInterface $sanitizer
     * @return void
     */
    public function addFilters(SanitizerInterface $sanitizer): void;
}