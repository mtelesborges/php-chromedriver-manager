<?php

use PHPUnit\Framework\TestCase;

final class ChromeExeFileTest extends TestCase
{
    public function testIfChromeExeFileChanged()
    {
        $file = "C:\\\\Program Files (x86)\\\\Google\\\\Chrome\\\\Application\\\\chrome.exe";
        $this->assertFileExists($file);
    }
}