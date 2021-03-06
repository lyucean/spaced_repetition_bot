<?php

namespace srbot\command;

use Exception;
use PHPUnit\Framework\TestCase;
use Telegram;

class NowTest extends TestCase
{

    public function testIndex()
    {
        try {
            // Create a stub for a class Telegram.
            $Telegram = $this->getMockBuilder(Telegram::class)
                ->onlyMethods(['ChatID'])
                ->getMock();

            $Telegram->expects($this->once())
                ->method('ChatID')
                ->willReturn(TELEGRAM_TEST_CHAT_ID);

            $action = new Now($Telegram);

            $action->index();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $this->assertTrue(true);
    }
}
