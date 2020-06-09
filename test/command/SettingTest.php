<?php

namespace srbot\command;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use srbot\core\DB;
use srbot\core\Telegram;

class SettingTest extends TestCase
{
    private MockObject $mock_telegram;
    private DB $db;

    public function testIndex()
    {
        try {
            $action = new Setting($this->mock_telegram);

            $action->index();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $this->assertTrue(true);
    }

    public function testChange_number()
    {
        try {
            $action = new Setting($this->mock_telegram);

            $action->change_number();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $this->assertTrue(true);
    }

    public function testSet_number()
    {
        $number = rand(1, MAXIMUM_OF_MESSAGES_PER_DAY);
        $this->mock_telegram->expects($this->any())
            ->method('Text')
            ->willReturn($number);

        try {
            $action = new Setting($this->mock_telegram);
            $action->set_number();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $schedule = $this->db->getSchedule(TELEGRAM_TEST_CHAT_ID);
        $this->assertSame($number, $schedule['quantity']);

        $this->db->setSchedule(TELEGRAM_TEST_CHAT_ID, ['quantity' => 1]);
    }

    public function testChange_time_zone()
    {
        try {
            $action = new Setting($this->mock_telegram);

            $action->change_time_zone();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $this->assertTrue(true);
    }

    public function testSet_time_zone()
    {
        $offset = rand(-12, +14);

        $this->mock_telegram->expects($this->any())
            ->method('Text')
            ->willReturn($offset);

        try {
            $action = new Setting($this->mock_telegram);
            $action->set_time_zone();
        } catch (Exception $e) {
            $this->fail($e);
        }

        $schedule = $this->db->getSchedule(TELEGRAM_TEST_CHAT_ID);
        $this->assertSame($offset, $schedule['time_zone_offset']);

        $this->db->setSchedule(TELEGRAM_TEST_CHAT_ID, ['time_zone_offset' => 3]);
    }

    public function testChange_interval()
    {
    }

    public function testSet_interval()
    {
    }

    protected function setUp(): void
    {
        // Create a stub for a class Telegram.
        $this->mock_telegram = $this->getMockBuilder(Telegram::class)
            ->onlyMethods(['ChatID', 'MessageID', 'Text'])
            ->getMock();

        $this->mock_telegram->expects($this->any())
            ->method('ChatID')
            ->willReturn(TELEGRAM_TEST_CHAT_ID);

        $this->db = new DB();
    }
}
