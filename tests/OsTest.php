<?php

use PHPUnit\Framework\TestCase;

final class OsTest extends TestCase
{
    public function testIfOsIsWin()
    {
        $this->assertEquals("WIN", strtoupper(substr(PHP_OS, 0, 3)));
    }
}