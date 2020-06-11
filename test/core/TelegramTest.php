<?php

namespace srbot\core;

use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{

    public function testSetChatID()
    {
        $telegram = new Telegram();
        $telegram->setChatID(TELEGRAM_TEST_CHAT_ID);
        $this->assertSame((int)TELEGRAM_TEST_CHAT_ID, (int)$telegram->ChatID());
    }
}
