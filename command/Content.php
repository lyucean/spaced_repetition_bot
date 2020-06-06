<?php

namespace srbot\command;


use Exception;
use srbot\core\DB;
use srbot\core\Telegram;

class Content
{
    private Telegram $telegram;
    private int $chat_id;
    private string $text;
    private int $content_id;
    private int $message_id;
    private DB $db;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->text = $this->telegram->Text();
        $this->chat_id = $this->telegram->ChatID();
        $this->chat_id = $this->telegram->MessageID();
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
        $this->content_id = $this->db->addContent(
            [
                'chat_id' => $this->chat_id,
                'text' => $this->text,
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
            'text' => 'I saved it 🙂'
        ];
        $this->telegram->sendMessage($content);
    }

    public function cancel()
    {
        $param = get_var_query($this->text);

        if (empty($param['content_id'])) {
            return (new Error($this->telegram))
                ->send('I did not find content_id!');
        }

        $this->content_id = $param['content_id'];

        $reply = 'Deleted! ID:' . $this->content_id;

        if (empty($query['content_id'])) {
            $reply = 'I did not find content_id';
        }

        try {
            $this->db->deleteContent($this->content_id);
        } catch (Exception $e) {
            return (new Error($this->telegram))
                ->send('I couldn\'t delete the entry! ID:' . $this->content_id);
        }

        $content = ['chat_id' => $this->chat_id, 'text' => $reply];
        $this->telegram->sendMessage($content);
    }
}
