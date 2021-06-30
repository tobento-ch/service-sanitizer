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
use Tobento\Service\Sanitizer\Filter\Trim;

/**
 * TrimFilterTest tests
 */
class TrimFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Trim())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Trim())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Trim())->apply('')
        );
    }
    
    public function testTrim()
    {        
        $this->assertSame(
            'foo',
            (new Trim())->apply(' foo')
        );
        
        $this->assertSame(
            'foo',
            (new Trim())->apply(' foo ')
        );
        
        $this->assertSame(
            'foo bar',
            (new Trim())->apply(' foo bar ')
        );
    }    
}