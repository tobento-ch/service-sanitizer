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
use Tobento\Service\Sanitizer\Filter\AlphaStrict;

/**
 * AlphaStrictFilterTest tests
 */
class AlphaStrictFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new AlphaStrict())->apply(555)
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new AlphaStrict())->apply(null)
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new AlphaStrict())->apply('')
        );
    }
    
    public function testReturnsOnlyAlpha()
    {        
        $this->assertSame(
            'Loremipsum',
            (new AlphaStrict())->apply('Lorem 4ipsum 5')
        );
        
        $this->assertSame(
            'Loremipsum',
            (new AlphaStrict())->apply('Lorem * ips<um ?=')
        );
    }    
}