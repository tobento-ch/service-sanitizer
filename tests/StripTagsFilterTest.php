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
use Tobento\Service\Sanitizer\Filter\StripTags;

/**
 * StripTagsFilterTest tests
 */
class StripTagsFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new StripTags())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new StripTags())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new StripTags())->apply('')
        );
    }
    
    public function testStripTags()
    {        
        $this->assertSame(
            'Lorem ipsum',
            (new StripTags())->apply('<p>Lorem ipsum</p>')
        );
        
        $this->assertSame(
            'Lorem ipsum',
            (new StripTags())->apply('<p class="foo">Lorem ipsum</p>')
        );
    }    
}