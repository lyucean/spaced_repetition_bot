<?php


namespace srbot\command;

use srbot\core\DB;
use srbot\core\Telegram;

class Now
{
    private Telegram $telegram;
    /**
     * @var mixed
     */
    private int $chat_id;
    /**
     * @var DB
     */
    private DB $db;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
        $this->db = new DB();
    }

    public function index()
    {
        $content = $this->db->getContentPrepared($this->chat_id);

        if (empty($content)) { // If there is nothing to send
            $this->telegram->sendMessage(
                [
                    'chat_id' => $this->chat_id,
                    'text' => "Your message list is empty.\nI have nothing to send you."
                ]
            );
            return;
        }

        $option = [
            [
                $this->telegram->buildInlineKeyBoardButton(
                    'Cancel add',
                    $url = '',
                    '/content/cancel?content_id=' . $content['content_id']
                ),
            ],
        ];

        $content = [
            'chat_id' => $this->chat_id,
            'reply_markup' => $this->telegram->buildInlineKeyBoard($option),
            'text' => $content['text']
        ];
        $this->telegram->sendMessage($content);
    }
}
