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
use Tobento\Service\Sanitizer\Filter\Lcfirst;

/**
 * LcfirstFilterTest tests
 */
class LcfirstFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new Lcfirst())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Lcfirst())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new Lcfirst())->apply('')
        );
    }
    
    public function testLcfirst()
    {        
        $this->assertSame(
            'lorem ipsum',
            (new Lcfirst())->apply('Lorem ipsum')
        );
        
        $this->assertSame(
            'lorem Ipsum',
            (new Lcfirst())->apply('Lorem Ipsum')
        );
    }    
}