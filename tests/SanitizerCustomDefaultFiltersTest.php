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

namespace Tobento\Service\Sanitizer\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Sanitizer\Sanitizer;
use Tobento\Service\Sanitizer\FilterNotFoundException;
use Tobento\Service\Sanitizer\Test\Mock\CustomDefaultFilters;

/**
 * SanitizerCustomDefaultFiltersTest tests
 */
class SanitizerCustomDefaultFiltersTest extends TestCase
{    
    public function testUsesCustomDefaultFilters()
    {
        $this->assertSame(
            'lorem ipsum',
            (new Sanitizer(new CustomDefaultFilters()))->sanitizing('lorem ipsum', 'cast:string')
        );
    }
    
    public function testThrowsFilterNotFoundException()
    {
        $this->expectException(FilterNotFoundException::class);
        
        (new Sanitizer(new CustomDefaultFilters()))->sanitizing('lorem ipsum', 'uppercase');
    }
}