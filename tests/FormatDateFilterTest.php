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
use Tobento\Service\Sanitizer\Filter\FormatDate;

/**
 * FormatDateFilterTest tests
 */
class FormatDateFilterTest extends TestCase
{
    public function testReturnsOriginalValueIfNotString()
    {        
        $this->assertSame(
            555,
            (new FormatDate())->apply(555, ['Y-m-d', 'd.m.Y'])
        );
    }
    
    public function testNullReturnsNull()
    {        
        $this->assertSame(
            null,
            (new FormatDate())->apply(null, ['Y-m-d', 'd.m.Y'])
        );
    }    
    
    public function testEmptyStringReturnsEmptyString()
    {        
        $this->assertSame(
            '',
            (new FormatDate())->apply('', ['Y-m-d', 'd.m.Y'])
        );
    }
    
    public function testReturnsOriginalValueIfCannotFormatDate()
    {        
        $this->assertSame(
            '<?=a',
            (new FormatDate())->apply('<?=a', ['Y-m-d', 'd.m.Y'])
        );
    }    
    
    public function testReturnsFormattedDate()
    {        
        $this->assertSame(
            '15.06.2021',
            (new FormatDate())->apply('2021-06-15', ['Y-m-d', 'd.m.Y'])
        );
        
        $this->assertSame(
            '15.06.2021 00:00',
            (new FormatDate())->apply('2021-06-15', ['Y-m-d', 'd.m.Y H:i'])
        );
    }    
}