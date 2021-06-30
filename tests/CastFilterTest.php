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
use Tobento\Service\Sanitizer\Filter\Cast;

/**
 * CastFilterTest tests
 */
class CastFilterTest extends TestCase
{
    public function testIfNullValueTakesDefaultValueString()
    {        
        $this->assertSame(
            'Default',
            (new Cast())->apply(null, ['string', 'Default'])
        );
        
        $this->assertSame(
            '555',
            (new Cast())->apply(null, ['string', 555])
        );
    }
    
    public function testIfNullValueTakesDefaultValueInt()
    {        
        $this->assertSame(
            555,
            (new Cast())->apply(null, ['int', 555])
        );
        
        $this->assertSame(
            555,
            (new Cast())->apply(null, ['int', '555'])
        );
        
        $this->assertSame(
            0,
            (new Cast())->apply(null, ['int', 'Lorem'])
        );
    }
    
    public function testIfNullValueTakesDefaultValueFloat()
    {        
        $this->assertSame(
            555.0,
            (new Cast())->apply(null, ['float', 555])
        );
        
        $this->assertSame(
            555.00,
            (new Cast())->apply(null, ['float', 555.00])
        );
        
        $this->assertSame(
            555.0,
            (new Cast())->apply(null, ['float', '555.00'])
        );
        
        $this->assertSame(
            0.0,
            (new Cast())->apply(null, ['float', 'Lorem'])
        );
    }
    
    public function testIfNullValueTakesDefaultValueBool()
    {        
        $this->assertSame(
            true,
            (new Cast())->apply(null, ['bool', true])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply(null, ['bool', false])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(null, ['bool', 1])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply(null, ['bool', 0])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(null, ['bool', '1'])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply(null, ['bool', '0'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(null, ['bool', 'true'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(null, ['bool', 'false'])
        );
    }
    
    public function testIfNullValueTakesDefaultValueArray()
    {        
        $this->assertSame(
            [],
            (new Cast())->apply(null, ['array', []])
        );
        
        $this->assertSame(
            ['foo'],
            (new Cast())->apply(null, ['array', ['foo']])
        );
    }
    
    public function testCastToInt()
    {        
        $this->assertSame(
            0,
            (new Cast())->apply('foo', ['int'])
        );
        
        $this->assertSame(
            0,
            (new Cast())->apply('foo5', ['int'])
        );
        
        $this->assertSame(
            55,
            (new Cast())->apply('55', ['int'])
        );
        
        $this->assertSame(
            55,
            (new Cast())->apply(55, ['int'])
        );
    }
    
    public function testCastToIntWithDefaultValue()
    {        
        $this->assertSame(
            555,
            (new Cast())->apply('foo', ['int', '555'])
        );
        
        $this->assertSame(
            555,
            (new Cast())->apply('foo', ['int', 555])
        );
        
        $this->assertSame(
            555,
            (new Cast())->apply(555, ['int', 700])
        );
        
        $this->assertSame(
            0,
            (new Cast())->apply('foo', ['int', null])
        );
    }
    
    public function testCastToFloat()
    {        
        $this->assertSame(
            0.0,
            (new Cast())->apply('foo', ['float'])
        );
        
        $this->assertSame(
            0.0,
            (new Cast())->apply('foo5', ['float'])
        );
        
        $this->assertSame(
            55.0,
            (new Cast())->apply('55', ['float'])
        );
        
        $this->assertSame(
            55.0,
            (new Cast())->apply(55, ['float'])
        );
    }
    
    public function testCastToFloatWithDefaultValue()
    {        
        $this->assertSame(
            555.0,
            (new Cast())->apply('foo', ['float', '555'])
        );
        
        $this->assertSame(
            555.00,
            (new Cast())->apply('foo', ['float', '555.00'])
        );
        
        $this->assertSame(
            555.0,
            (new Cast())->apply('foo', ['float', 555.0])
        );
        
        $this->assertSame(
            555.0,
            (new Cast())->apply(555.0, ['float', 600.0])
        );
        
        $this->assertSame(
            0.0,
            (new Cast())->apply('foo', ['float', null])
        );
    }
    
    public function testCastToString()
    {        
        $this->assertSame(
            '0',
            (new Cast())->apply(0.0, ['string'])
        );
        
        $this->assertSame(
            '',
            (new Cast())->apply([], ['string'])
        );
        
        $this->assertSame(
            'foo5',
            (new Cast())->apply('foo5', ['string'])
        );
        
        $this->assertSame(
            '55',
            (new Cast())->apply('55', ['string'])
        );
        
        $this->assertSame(
            '55',
            (new Cast())->apply(55, ['string'])
        );
    } 
    
    public function testCastToStringWithDefaultValue()
    {        
        $this->assertSame(
            '0',
            (new Cast())->apply(0.0, ['string', 'bar'])
        );
        
        $this->assertSame(
            'bar',
            (new Cast())->apply([], ['string', 'bar'])
        );
        
        $this->assertSame(
            '',
            (new Cast())->apply([], ['string', []])
        );
    }
    
    public function testCastToBool()
    {        
        $this->assertSame(
            false,
            (new Cast())->apply(0, ['bool'])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply([], ['bool'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply('foo5', ['bool'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply('55', ['bool'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(55, ['bool'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply(true, ['bool'])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply('1', ['bool'])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply('0', ['bool'])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply(false, ['bool'])
        );
    }
    
    public function testCastToBoolWithDefaultValue()
    {        
        $this->assertSame(
            true,
            (new Cast())->apply([], ['bool', true])
        );
        
        $this->assertSame(
            true,
            (new Cast())->apply([], ['bool', 'true'])
        );
        
        $this->assertSame(
            false,
            (new Cast())->apply([], ['bool', []])
        );
    }
    
    public function testCastToArray()
    {        
        $this->assertSame(
            [],
            (new Cast())->apply(0.0, ['array'])
        );
        
        $this->assertSame(
            ['foo'],
            (new Cast())->apply(['foo'], ['array'])
        );
        
        $this->assertSame(
            [],
            (new Cast())->apply('foo', ['array'])
        );
        
        $this->assertSame(
            ['foo'],
            (new Cast())->apply('{"0": "foo"}', ['array'])
        );
    }
    
    public function testCastToArrayWithDefaultValue()
    {        
        $this->assertSame(
            ['foo'],
            (new Cast())->apply(0.0, ['array', ['foo']])
        );
        
        $this->assertSame(
            ['bar'],
            (new Cast())->apply(['bar'], ['array', ['foo']])
        );
        
        $this->assertSame(
            [],
            (new Cast())->apply(0.0, ['array', 'foo'])
        );
        
        $this->assertSame(
            [],
            (new Cast())->apply(0.0, ['array', null])
        );
    }     
}