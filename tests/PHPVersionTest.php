<?php

use PHPUnit\Framework\TestCase;

final class PHPVersionTest extends TestCase
{
    public function testIfPHPVersionIs74OrGreater()
    {
        $version = phpversion();
        $version = (double) substr($version, 0, 3);

        $this->assertGreaterThanOrEqual(7.4, $version);
    }
}