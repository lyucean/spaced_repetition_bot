<?php


namespace srbot\Controller;

use srbot\Model\Data;
use srbot\Model\Telegram;

/**
 * Responsible for the processing of all incoming messages from the user
 * Class Processing
 * @package srbot\Controller
 */
class Processing
{
    private $telegram;
    private $db;

    public function __construct()
    {
        $this->telegram = new Telegram();
        $this->db = new Data();
    }

    public function checkMessage()
    {
        // Get all the new updates and set the new correct update_id
        $this->telegram->getUpdates(0, 10);
        for ($i = 0; $i < $this->telegram->UpdateCount(); $i++) {
            // You NEED to call serveUpdate before accessing the values of message in Telegram Class
            $this->telegram->serveUpdate($i);
            $text = $this->telegram->Text();
            $chat_id = $this->telegram->ChatID();
            $message_id = $this->telegram->MessageID();

            if ($this->telegram->getUpdateType() == 'callback_query') {
                $param = parse_url($text);
                switch ($param['path']) {
                    case '/cancelContent':
                        parse_str($param['query'], $query);
                        if (empty($query['content_id'])) {
                            $reply = 'I did not find content_id';
                            break;
                        }

                        $this->db->deleteContent($query['content_id']);
                        $reply = 'Deleted! ID:' . $query['content_id'];

                        break;
                    default:
                        $reply = 'I did not find such a callback query';
                }

                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $this->telegram->sendMessage($content);
            } elseif (!is_null($text) && !is_null($chat_id)) {
                if ($text == '/start') {
                    $reply = 'Hey, the bot is in development, it is too early to use it :)';
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $this->telegram->sendMessage($content);
                } elseif ($text == '/now') {
                    (new  Schedule())->sendContent($chat_id);
                } elseif (!empty($text)) {
                    $content_id = $this->db->addContent(
                        [
                            'chat_id' => $chat_id,
                            'text' => $text,
                            'message_id' => $message_id,
                            'rating' => 0,
                            'show' => 1,
                        ]
                    );

                    $option = [
                        [
                            $this->telegram->buildInlineKeyBoardButton(
                                'Cancel add',
                                $url = '',
                                '/cancelContent?content_id=' . $content_id
                            ),
//                            $this->telegram->buildInlineKeyBoardButton('Menu', $url = '', $callback_data = '/menu'),
                        ],
                    ];

                    $keyb = $this->telegram->buildInlineKeyBoard($option);

                    $content = [
                        'chat_id' => $chat_id,
                        'reply_markup' => $keyb,
                        'text' => 'Saved 🙂 ID:' . $content_id
                    ];
                    $this->telegram->sendMessage($content);
                }
            } else {
                $reply = 'This is a team I do not understand';
                $content = ['chat_id' => $chat_id, 'text' => $reply];
                $this->telegram->sendMessage($content);
            }
        }
    }
}
