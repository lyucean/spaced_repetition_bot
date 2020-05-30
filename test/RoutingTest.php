<?php

namespace srbot\core;

use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{
    public function testIndex()
    {
        $this->assertSame(0, count([]));
    }

    public function testRequireFile()
    {
        $r = new Routing();
        $file = $r->requireFile("Start");

        $this->assertTrue($file);
    }
}
