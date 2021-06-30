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
use Tobento\Service\Sanitizer\Filter\ArrayFilter;

/**
 * ArrayFilterTest tests
 */
class ArrayFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotArray()
    {        
        $this->assertSame(
            555,
            (new ArrayFilter(new Sanitizer()))->apply(555)
        );
        
        $this->assertSame(
            'foo',
             (new ArrayFilter(new Sanitizer()))->apply('foo')
        );
    }
    
    public function testSimpleArray()
    {        
        $this->assertSame(
            ['FOO', 'BAR'],
             (new ArrayFilter(new Sanitizer()))->apply([
                'foo', 'bar'
            ], ['uppercase'])
        );
    }
    
    public function testWithKeyFilters()
    {        
        $this->assertSame(
            ['Foo' => 'FOO', 'Bar' => 'BAR'],
             (new ArrayFilter(new Sanitizer()))->apply([
                'foo' => 'foo', 'bar' => 'bar'
            ], ['uppercase', 'ucfirst'])
        );
    }    
}