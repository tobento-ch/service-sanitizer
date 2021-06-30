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
use Tobento\Service\Sanitizer\FilterNotFoundException;

/**
 * SanitizerTest tests
 */
class SanitizerTest extends TestCase
{    
    public function testSanitizingMethodThrowsFilterNotFoundException()
    {
        $this->expectException(FilterNotFoundException::class);
        
        (new Sanitizer())->sanitizing('lorem ipsum', 'foo');
    }

    public function testSanitizingMethodWithNullData()
    {        
        $this->assertSame(
            '',
            (new Sanitizer())->sanitizing(null, 'cast:string|ucfirst')
        );
    }
    
    public function testSanitizingMethodWithNoFiltersReturnsSame()
    {        
        $this->assertSame(
            'lorem ipsum',
            (new Sanitizer())->sanitizing('lorem ipsum', '')
        );
    }    
    
    public function testSanitizingMethodWithStringFilters()
    {        
        $this->assertSame(
            'Lorem ipsum',
            (new Sanitizer())->sanitizing('lorem ipsum', 'cast:string|ucfirst')
        );
    }
    
    public function testSanitizingMethodWithArrayFilters()
    {        
        $this->assertSame(
            'Lorem ipsum',
            (new Sanitizer())->sanitizing('lorem ipsum', ['cast' => ['string'], 'ucfirst'])
        );
    }

    public function testSanitizeMethodThrowsFilterNotFoundException()
    {
        $this->expectException(FilterNotFoundException::class);
        
        (new Sanitizer())->sanitize(['name' => ''], ['name' => 'foo']);
    }
    
    public function testSanitizeMethodWithStringFilters()
    {        
        $this->assertSame(
            [
                'name' => 'Thomas',
                'desc' => 'Lorem ipsum',
            ],
            (new Sanitizer())->sanitize(
                [
                    'name' => 'thomas',
                    'desc' => '<p>Lorem ipsum</p>',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                    'desc' => 'cast:string|stripTags',
                ],
            )
        );
    }
    
    public function testSanitizeMethodWithStringAndArrayFilters()
    {        
        $this->assertSame(
            [
                'name' => 'Thomas',
                'desc' => 'Lorem ipsum',
            ],
            (new Sanitizer())->sanitize(
                [
                    'name' => 'thomas',
                    'desc' => '<p>Lorem ipsum</p>',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                    'desc' => ['cast' => ['string'], 'stripTags'],
                ],
            )
        );
    }
    
    public function testSanitizeMethodWithoutStrictModeDoesNotSanitizeDataIfNotExists()
    {        
        $this->assertEquals(
            [
                'foo' => 'bar',
            ],
            (new Sanitizer())->sanitize(
                [
                    'foo' => 'bar',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                ],
                strictSanitation: false,
                returnSanitizedOnly: false,
            )
        );
    }

    public function testSanitizeMethodWithStrictModeSanitizesDataIfNotExists()
    {        
        $this->assertEquals(
            [
                'name' => '',
                'foo' => 'bar',
            ],
            (new Sanitizer())->sanitize(
                [
                    'foo' => 'bar',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                ],
                strictSanitation: true,
                returnSanitizedOnly: false,
            )
        );
    }
    
    public function testSanitizeMethodWithoutStrictModeAndWithReturnSanitizedOnly()
    {        
        $this->assertEquals(
            [
                'desc' => 'Lorem ipsum',
            ],
            (new Sanitizer())->sanitize(
                [
                    'desc' => 'lorem ipsum',
                    'foo' => 'bar',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                    'desc' => 'cast:string|ucfirst',
                ],
                strictSanitation: false,
                returnSanitizedOnly: true,
            )
        );
    }
    
    public function testSanitizeMethodWithStrictModeAndWithReturnSanitizedOnly()
    {        
        $this->assertEquals(
            [
                'name' => '',
                'desc' => 'Lorem ipsum',
            ],
            (new Sanitizer())->sanitize(
                [
                    'desc' => 'lorem ipsum',
                    'foo' => 'bar',
                ],
                [
                    'name' => 'cast:string|ucfirst',
                    'desc' => 'cast:string|ucfirst',
                ],
                strictSanitation: true,
                returnSanitizedOnly: true,
            )
        );
    }    
}