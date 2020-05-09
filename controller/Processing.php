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
            // Check if the text is a command
            if (!is_null($text) && !is_null($chat_id)) {
                if ($text == '/start') {
                    $reply = 'Hey, the bot is in development, it is too early to use it :)';
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $this->telegram->sendMessage($content);
                } elseif ($text == '/test') {
                    $reply = 'test' . gmdate("h:i:s");
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $this->telegram->sendMessage($content);
                } elseif (mb_strtolower($text) == 'согласен') {
                    $reply = '🤘';
                    $content = ['chat_id' => $chat_id, 'text' => $reply];
                    $this->telegram->sendMessage($content);
                } elseif ($text == '/keyboard') {
                    if ($this->telegram->messageFromGroup()) {
                        $reply = 'Chat Group';
                    } else {
                        $reply = 'Private Chat';
                    }
                    // Create option for the custom keyboard. Array of array string
                    $option = [['Add', 'Menu']];
                    // Get the keyboard
                    $keyb = $this->telegram->buildKeyBoard($option);
                    $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $reply];
                    $this->telegram->sendMessage($content);
                } elseif ($text == '/keyhide') {
                    $keyb = $this->telegram->buildForceReply($selective = true);
                    $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => '43'];
                    $this->telegram->sendMessage($content);
                } elseif ($text == '/inlinekeyboard') {
                    // Shows the Inline Keyboard and Trigger a callback on a button press
                    $option = [
                        [
                            $this->telegram->buildInlineKeyBoardButton('Add', $url = '', $callback_data = '/add'),
                            $this->telegram->buildInlineKeyBoardButton('Menu', $url = '', $callback_data = '2'),
                        ],
                    ];

                    $keyb = $this->telegram->buildInlineKeyBoard($option);
                    $content = [
                        'chat_id' => $chat_id,
                        'reply_markup' => $keyb,
                        'text' => 'This is an InlineKeyboard Test with Callbacks'
                    ];
                    $this->telegram->sendMessage($content);
                } elseif (!empty($text)) {
                    $this->db->addContent(
                        [
                            'chat_id' => $chat_id,
                            'text' => $text,
                            'message_id' => $message_id,
                            'rating' => 0,
                            'show' => 1,
                        ]
                    );

                    $content = ['chat_id' => $chat_id, 'text' => 'Saved :D'];
                    $this->telegram->sendMessage($content);
                }
            }
        }
    }
}
