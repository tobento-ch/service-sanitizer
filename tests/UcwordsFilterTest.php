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
use Tobento\Service\Sanitizer\Filter\Ucwords;

/**
 * UcwordsFilterTest tests
 */
class UcwordsFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Ucwords())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Ucwords())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Ucwords())->apply('')
        );
    }
    
    public function testUcwords()
    {        
        $this->assertSame(
            'Lorem Ipsum',
            (new Ucwords())->apply('lorem ipsum')
        );
        
        $this->assertSame(
            'Lorem Ipsum',
            (new Ucwords())->apply('lorem Ipsum')
        );
    }    
}