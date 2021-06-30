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
use Tobento\Service\Sanitizer\Filter\Lowercase;

/**
 * LowercaseFilterTest tests
 */
class LowercaseFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Lowercase())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Lowercase())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Lowercase())->apply('')
        );
    }
    
    public function testLowercase()
    {        
        $this->assertSame(
            'lorem ipsum',
            (new Lowercase())->apply('Lorem ipsum')
        );
        
        $this->assertSame(
            'lorem ipsum',
            (new Lowercase())->apply('Lorem Ipsum')
        );
        
        $this->assertSame(
            'lorem',
            (new Lowercase())->apply('LOREM')
        );
    }    
}