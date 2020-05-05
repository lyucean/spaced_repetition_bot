<?php

namespace srbot\Controller;

use srbot\Model\Data;
use srbot\Model\Message;

class Schedule
{
    public function check()
    {
        $data = new Data();

        foreach ($data->getSendingList() as $item) {
            $content = $data->getContentPrepared($item['chat_id']);

            if (!empty($content)) {
                (new Message)->Send(TELEGRAM_CHAT_ID, $content);
            }

            $data->setScheduleDailyStatusSent($item['schedule_daily_id']);
        }
    }
}
