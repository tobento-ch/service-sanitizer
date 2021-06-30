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
use Tobento\Service\Sanitizer\Filter\Remove;

/**
 * RemoveFilterTest tests
 */
class RemoveFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotArray()
    {        
        $this->assertSame(
            555,
            (new Remove())->apply(555, ['foo'])
        );
        
        $this->assertSame(
            '',
            (new Remove())->apply('', ['foo'])
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new Remove())->apply(null, ['foo'])
        );
    }    
    
    public function testRemoveWithStrings()
    {        
        $this->assertSame(
            [0 => 'bar', 2 => 'zoo'],
            (new Remove())->apply(['bar', 'foo', 'zoo'], ['foo'])
        );
        
        $this->assertSame(
            ['bar'],
            (new Remove())->apply(['bar', 'foo', 'zoo'], ['foo', 'zoo'])
        );
        
        $this->assertSame(
            ['bar', 'foo', 'zoo'],
            (new Remove())->apply(['bar', 'foo', 'zoo'], [])
        );
    }
    
    public function testRemoveWithNumbers()
    {        
        $this->assertSame(
            [0 => 555, 2 => 777],
            (new Remove())->apply([555, 666, 777], [666])
        );
    }    
}