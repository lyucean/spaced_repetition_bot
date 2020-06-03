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
        $this->assertSame(
            'Delete',
            (new Action('/StarT/delete'))->getMethod()
        );

        $this->assertSame(
            'Delete',
            (new Action('/StarT/delete/all?id=123'))->getMethod()
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
}
