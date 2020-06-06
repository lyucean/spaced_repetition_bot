<?php

namespace srbot\core;

use Exception;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
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

            $mock_telegram = $this->getMockBuilder(Telegram::class)
                ->onlyMethods(['ChatID'])
                ->getMock();

            $mock_telegram->expects($this->once())
                ->method('ChatID')
                ->willReturn(TELEGRAM_TEST_CHAT_ID);

            $action->execute($mock_telegram);
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
