<?php


namespace srbot\Controller;

use srbot\Model\Data;
use Telegram;

/**
 * Responsible for the processing of all incoming messages from the user
 * Class MessageProcessing
 * @package srbot\Controller
 */
class MessageProcessing
{
    private $telegram;
    private $bd;

    public function __construct()
    {
        $this->telegram = new Telegram(
            TELEGRAM_TOKEN, true, [
                              'type' => PROXY_TYPE,
                              'auth' => PROXY_AUTH,
                              'url' => PROXY_IP,
                              'port' => PROXY_PORT,
                          ]
        );

        $this->bd = new Data();
    }

    public function getMessage()
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
                } elseif (!empty($text)) {
                    $this->bd->addContent(
                        [
                            'chat_id' => $chat_id,
                            'text' => $text,
                            'message_id' => $message_id,
                            'rating' => 0,
                            'show' => 0,
                        ]
                    );

                    $content = ['chat_id' => $chat_id, 'text' => 'Saved :D'];
                    $this->telegram->sendMessage($content);
                }
            }
        }
    }
}
