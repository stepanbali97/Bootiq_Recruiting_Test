<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Counter;

use App\Counter\FileProductQueryCounter;
use Codeception\Test\Unit;

/**
 * File product query counter test
 */
class FileProductQueryCounterTest extends Unit
{
    private string $filePath;

    /**
     * @return void
     */
    public function testIncrementCreatesFileAndAddsFirstValue(): void
    {
        $counter = new FileProductQueryCounter($this->filePath);
        $counter->increment('123');

        clearstatcache(true, $this->filePath);
        $content = json_decode(file_get_contents($this->filePath), true);

        $this->assertArrayHasKey('123', $content);
        $this->assertSame(1, $content['123']);
    }

    /**
     * @return void
     */
    public function testIncrementIncreasesExistingValue(): void
    {
        $counter = new FileProductQueryCounter($this->filePath);

        $counter->increment('123');
        clearstatcache(true, $this->filePath); 
        
        $counter->increment('123');
        clearstatcache(true, $this->filePath);

        $content = json_decode(file_get_contents($this->filePath), true);

        $this->assertSame(2, $content['123']);
    }

    /**
     * @return void
     */
    public function testIncrementWorksForMultipleProducts(): void
    {
        $counter = new FileProductQueryCounter($this->filePath);

        $counter->increment('123');
        $counter->increment('456');

        clearstatcache(true, $this->filePath); 
        $content = json_decode(file_get_contents($this->filePath), true);

        $this->assertSame(1, $content['123']);
        $this->assertSame(1, $content['456']);
    }

    /**
     * @return void
     */
     protected function _before(): void
    {
        $this->filePath = tempnam(sys_get_temp_dir(), 'product_counter_test_');
        file_put_contents($this->filePath, json_encode([]));
        
        clearstatcache(true, $this->filePath);
    }

    /**
     * @return void
     */
    protected function _after(): void
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }
}
