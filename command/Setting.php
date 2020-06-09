<?php


namespace srbot\command;

use srbot\core\DB;
use srbot\core\Telegram;

class Setting
{
    private Telegram $telegram;
    private int $chat_id;
    private DB $db;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
        $this->db = new DB();
    }

    public function index()
    {
        $schedule = $this->db->getSchedule($this->chat_id);

        $hour_start = $schedule['hour_start'] ?? 9;
        $hour_end = $schedule['hour_end'] ?? 14;
        $quantity = $schedule['quantity'] ?? 1;
        $time_zone_offset = $schedule['time_zone_offset'] ?? 3;

        $option = [
            [
                $this->telegram->buildInlineKeyBoardButton(
                    'Message Interval: from ' . $hour_start . ':00 to ' . $hour_end . ':00',
                    $url = '',
                    '/setting/change_interval'
                )
            ],
            [
                $this->telegram->buildInlineKeyBoardButton(
                    'Number of messages: ' . $quantity . ' ' . (1 == $quantity ? 'message' : 'messages'),
                    $url = '',
                    '/setting/change_number'
                )
            ],
            [
                $this->telegram->buildInlineKeyBoardButton(
                    'Your time zone: ' . ($time_zone_offset < 0 ? '' : '+') . $time_zone_offset,
                    $url = '',
                    '/setting/change_time_zone'
                )
            ],
        ];

        $content = [
            'chat_id' => $this->chat_id,
            'reply_markup' => $this->telegram->buildInlineKeyBoard($option),
            'text' => 'Choose to change'
        ];
        $this->telegram->sendMessage($content);
    }

    public function change_number()
    {
        //Put the command on hold;
        $this->db->setWaitingCommand($this->chat_id, '/setting/set_number');

        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => 'Enter how many messages to send you per day [max ' . MAXIMUM_OF_MESSAGES_PER_DAY . ']'
            ]
        );
    }

    public function set_number()
    {
        $number = (int)$this->telegram->Text();

        if ($number < 0 || MAXIMUM_OF_MESSAGES_PER_DAY < $number) {
            (new Error($this->telegram))->send(
                'I am waiting for a number from 0 to ' . MAXIMUM_OF_MESSAGES_PER_DAY,
                false
            );
            // return the command on hold;
            $this->db->setWaitingCommand($this->chat_id, '/setting/set_number');
            return;
        }

        $this->db->setSchedule($this->chat_id, ['quantity' => $number]);

        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => 'Save: ' . $number . ' per day'
            ]
        );
    }

    public function change_time_zone()
    {
        //Put the command on hold;
        $this->db->setWaitingCommand($this->chat_id, '/setting/set_time_zone');

        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => 'Enter your time zone offset [number only, eg -3 or +2]'
//                    . "\n" . '[wiki/Time_zone](https://en.wikipedia.org/wiki/Time_zone)'
            ]
        );
    }

    public function set_time_zone()
    {
        $offset = (int)$this->telegram->Text();

        if ($offset < -13 || 14 < $offset) {
            (new Error($this->telegram))->send(
                'I am waiting for a number from -12 to 14',
                false
            );
            // return the command on hold;
            $this->db->setWaitingCommand($this->chat_id, '/setting/set_number');
            return;
        }

        $this->db->setSchedule($this->chat_id, ['time_zone_offset' => $offset]);

        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => 'Save offset: ' . $offset
            ]
        );
    }

    public function change_interval()
    {
    }

    public function set_interval()
    {
    }
}
