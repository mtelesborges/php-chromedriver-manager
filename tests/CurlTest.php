<?php

use PHPUnit\Framework\TestCase;

final class CurlTest extends TestCase
{
    public function testIfCurlIsEnabled():void
    {
        $extensions = get_loaded_extensions();
        $this->assertContains("curl", $extensions);
    }
}