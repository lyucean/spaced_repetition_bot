<?php


namespace srbot\command;


use srbot\core\DB;
use Telegram;

class Catalog
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
        $total_length = 0;
        $max_line_length = 30;
        $max_message_length = 4096;

        foreach ($this->db->getContents($this->chat_id) as $content) {
            $text = $content['text'];
            $id = $content['content_id'];

            $total_length += mb_strlen($text);

            if ($max_message_length < $total_length) {
                $this->telegram->sendMessage(
                    [
                        'chat_id' => $this->chat_id,
                        'text' => empty($contents) ? 'Your list is empty.' : implode("\n", $contents)
                    ]
                );
                $total_length = 0;
                $contents = [];
            }

            $text = remove_http($text);

            if ($max_line_length < mb_strlen($text)) {
                $text = mb_strimwidth($text, 0, $max_line_length, "...");
            }

            $contents[] = '#' . HASHTAG_PREFIX . $id . ' ' . $text;
        }

        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => !isset($contents) ? 'Your list is empty.' : implode("\n", $contents)
            ]
        );
    }

}
