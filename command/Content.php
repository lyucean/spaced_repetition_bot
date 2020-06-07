<?php

namespace srbot\command;


use srbot\core\DB;
use srbot\core\Telegram;

class Content
{
    private Telegram $telegram;
    private int $chat_id = 0;
    private int $content_id = 0;
    private int $message_id = 0;
    private DB $db;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
        $this->message_id = $this->telegram->MessageID();
        $this->db = new DB();
    }

    public function __debugInfo()
    {
        return [
            'content_id' => $this->content_id,
        ];
    }

    public function add()
    {
        if ('message' != $this->telegram->getUpdateType()) {
            (new Error($this->telegram))->send('This is not a message!', false);
            return;
        }

        $this->content_id = $this->db->addContent(
            [
                'chat_id' => $this->chat_id,
                'text' => $this->telegram->Text(),
                'message_id' => $this->message_id,
                'rating' => 0,
                'show' => 1,
            ]
        );

        $option = [
            [
                $this->telegram->buildInlineKeyBoardButton(
                    'Cancel add',
                    $url = '',
                    '/content/cancel?content_id=' . $this->content_id
                ),
                //$this->telegram->buildInlineKeyBoardButton('Menu', $url = '', $callback_data = '/menu'),
            ],
        ];

        $content = [
            'chat_id' => $this->chat_id,
            'reply_markup' => $this->telegram->buildInlineKeyBoard($option),
            'text' => 'I saved it 🙂 №' . $this->content_id
        ];
        $this->telegram->sendMessage($content);
    }

    public function cancel()
    {
        if ('callback_query' != $this->telegram->getUpdateType()) {
            (new Error($this->telegram))->send('This is not a callback query!', false);
            return;
        }

        $param = get_var_query($this->telegram->Text());

        if (empty($param['content_id'])) {
            (new Error($this->telegram))->send('I did not find content_id!');
        }

        $this->content_id = $param['content_id'];

        $reply = 'Deleted! ID:' . $this->content_id;

        if (!$this->db->deleteContent($this->content_id)) {
            $reply = 'This content has already been removed!';
        }

        $content = ['chat_id' => $this->chat_id, 'text' => $reply];
        $this->telegram->sendMessage($content);
    }
}
