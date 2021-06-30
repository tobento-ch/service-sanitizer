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
use Tobento\Service\Sanitizer\Filter\Uppercase;

/**
 * UppercaseFilterTest tests
 */
class UppercaseFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Uppercase())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Uppercase())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Uppercase())->apply('')
        );
    }
    
    public function testLowercase()
    {        
        $this->assertSame(
            'LOREM IPSUM',
            (new Uppercase())->apply('Lorem ipsum')
        );
        
        $this->assertSame(
            'LOREM IPSUM',
            (new Uppercase())->apply('Lorem Ipsum')
        );
        
        $this->assertSame(
            'LOREM',
            (new Uppercase())->apply('LOREM')
        );
    }    
}