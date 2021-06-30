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
use Tobento\Service\Sanitizer\Filter\Ucfirst;

/**
 * UcfirstFilterTest tests
 */
class UcfirstFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Ucfirst())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Ucfirst())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Ucfirst())->apply('')
        );
    }
    
    public function testUcfirst()
    {        
        $this->assertSame(
            'Lorem ipsum',
            (new Ucfirst())->apply('lorem ipsum')
        );
        
        $this->assertSame(
            'Lorem Ipsum',
            (new Ucfirst())->apply('lorem Ipsum')
        );
    }    
}