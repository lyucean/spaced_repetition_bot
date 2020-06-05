<?php

namespace srbot\core;

use Exception;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testInitRoute()
    {
        $this->assertSame(
            '/Start',
            (new Action('/start'))->getRoute()
        );

        $this->assertSame(
            '/Start',
            (new Action('/start/delete'))->getRoute()
        );
        $this->assertSame(
            '/Start',
            (new Action('/Start/delete'))->getRoute()
        );
    }

    public function testInitMethod()
    {
        $method = md5(rand(10, 100));

        $this->assertSame(
            ucfirst($method),
            (new Action("/StarT/{$method}"))->getMethod()
        );

        $this->assertSame(
            ucfirst($method),
            (new Action("/StarT/{$method}/all?id=123"))->getMethod()
        );
    }

    public function testExecute()
    {
        try {
            $action = new Action('/start');

            // Create a stub for a class Telegram.
            $Telegram = $this->createMock(Telegram::class);
            $action->execute($Telegram);
        } catch (Exception $e) {
            $this->fail($e);
        }

        $this->assertTrue(true);
    }

    public function testErrorRoute()
    {
        $this->assertNull(
            (new Action('/' . md5(rand(10, 100))))->getRoute()
        );
        $this->assertNull(
            (new Action('/__call'))->getRoute()
        );
    }
}
