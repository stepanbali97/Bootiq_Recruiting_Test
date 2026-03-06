<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Counter;

use App\Counter\ProductQueryCounterInterface;

/**
 * File product query counter
 */
class FileProductQueryCounter implements ProductQueryCounterInterface
{
    private string $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        
        $dir = dirname($this->filePath);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    /**
     * Atomically increments the view count for a specific product ID in a JSON file.
     * 
     * @param string $id
     */
    public function increment(string $id): void
    {
        $fileHandle = fopen($this->filePath, 'c+');
        
        if (!$fileHandle) {
            return;
        }

        if (flock($fileHandle, LOCK_EX)) {
            rewind($fileHandle);
            $content = stream_get_contents($fileHandle);
            $data = json_decode($content, true) ?: [];
            
            if (!is_array($data)) {
                $data = [];
            }

            $data[$id] = ($data[$id] ?? 0) + 1;

            ftruncate($fileHandle, 0);
            rewind($fileHandle);
            fwrite($fileHandle, json_encode($data));

            flock($fileHandle, LOCK_UN);
        }
        
        fclose($fileHandle);
    }
}
