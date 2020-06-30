<?php

namespace srbot\model;

use PHPUnit\Framework\TestCase;

class ProcessingTest extends TestCase
{

    public function testCheck()
    {
        // if it is a request for a specific message
        if (!preg_match('/^\/_[0-9]+$/', '/_32')) {
            $this->fail();
        }
        // if it is a request for a specific message
        if (preg_match('/^\/_[0-9]+$/', '/_test')) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
