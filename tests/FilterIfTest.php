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
use Tobento\Service\Sanitizer\Filter\FilterIf;
use Tobento\Service\Collection\Collection;

/**
 * FilterIfTest tests
 */
class FilterIfTest extends TestCase
{
    public function testReturnsTrueIfMatchesValue()
    {        
        $this->assertTrue(
            (new FilterIf())->apply(
                [
                    null,
                    new Collection([
                        'country' => 'CH',
                    ]),
                ],
                ['country', 'CH'],
            )
        );
    }
    
    public function testReturnsFalseIfNotMatchesValue()
    {        
        $this->assertFalse(
            (new FilterIf())->apply(
                [
                    null,
                    new Collection([
                        'country' => 'CH',
                    ]),
                ],
                ['country', 'DE'],
            )
        );
    }
    
    public function testReturnsFalseIfValueMissing()
    {        
        $this->assertFalse(
            (new FilterIf())->apply(
                [
                    null,
                    new Collection(),
                ],
                ['country', 'DE'],
            )
        );
    }
    
    public function testReturnsFalseIfParametersMissing()
    {        
        $this->assertFalse(
            (new FilterIf())->apply(
                [
                    null,
                    new Collection([
                        'country' => 'CH',
                    ]),
                ],
                [],
            )
        );
    }    
}