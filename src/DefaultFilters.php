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
 * DefaultFilters
 */
class DefaultFilters implements FiltersInterface
{
    /**
     * Add the filters to the sanitizer.
     *
     * @param SanitizerInterface $sanitizer
     * @return void
     */
    public function addFilters(SanitizerInterface $sanitizer): void
    {        
        // Cast value to the given type
        $sanitizer->addFilter('cast', new \Tobento\Service\Sanitizer\Filter\Cast());

        // Apply filter on if a value matches
        $sanitizer->addFilter('filterIf', new \Tobento\Service\Sanitizer\Filter\FilterIf());

        // Format Date
        $sanitizer->addFilter('date', new \Tobento\Service\Sanitizer\Filter\FormatDate());            

        // Remove values
        $sanitizer->addFilter('remove', new \Tobento\Service\Sanitizer\Filter\Remove());
        
        // Array
        $sanitizer->addFilter('array', new \Tobento\Service\Sanitizer\Filter\ArrayFilter($sanitizer));

        // Trim
        $sanitizer->addFilter('trim', new \Tobento\Service\Sanitizer\Filter\Trim());

        // Digit
        $sanitizer->addFilter('digit', new \Tobento\Service\Sanitizer\Filter\Digit());

        // Alpha Strict
        $sanitizer->addFilter('alphaStrict', new \Tobento\Service\Sanitizer\Filter\AlphaStrict());

        // Strip tags
        $sanitizer->addFilter('stripTags', new \Tobento\Service\Sanitizer\Filter\StripTags());

        // Uppercase the first character of each word in a string
        $sanitizer->addFilter('ucwords', new \Tobento\Service\Sanitizer\Filter\Ucwords());

        // Make a string's first character lowercase
        $sanitizer->addFilter('lcfirst', new \Tobento\Service\Sanitizer\Filter\Lcfirst());

        // Make a string's first character uppercase
        $sanitizer->addFilter('ucfirst', new \Tobento\Service\Sanitizer\Filter\Ucfirst());

        // Make a string lowercase
        $sanitizer->addFilter('lowercase', new \Tobento\Service\Sanitizer\Filter\Lowercase());

        // Make a string uppercase
        $sanitizer->addFilter('uppercase', new \Tobento\Service\Sanitizer\Filter\Uppercase());        
    }    
}