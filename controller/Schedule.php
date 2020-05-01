<?php


namespace srbot\Controller;

use srbot\Model\Data;
use srbot\Model\Message;

class Schedule
{
    public function check()
    {
        $hour = date("G");
        $minute = date("i");

        if (7 < $hour && $hour < 21 && $minute == $hour) {
            $data = new Data();
            $content = $data->getContentPrepared(TELEGRAM_CHAT_ID);

            if (!empty($content)) {
                (new Message)->Send(TELEGRAM_CHAT_ID, $content);
            }
        }
    }

}
