<?php

namespace srbot\Controller;

use DateTime;
use Exception;
use srbot\Model\Data;
use srbot\Model\Message;

class Schedule
{
    private $bd;

    public function __construct()
    {
        $this->bd = new Data();
    }

    /**
     * Checking to see if it's time for an alert, if it is, it sends it out
     */
    public function check()
    {
        foreach ($this->bd->getSendingDailyNow() as $item) {
            $content = $this->bd->getContentPrepared($item['chat_id']);

            if (!empty($content)) {
                (new Message)->SendText(TELEGRAM_CHAT_ID, $content['text']);

                $this->bd->addDateReminderContent($content['content_id']);
            }

            $this->bd->setScheduleDailyStatusSent($item['schedule_daily_id']);
        }
    }

    /**
     * Generates the date and time of the alert in mysql format with an offset from the time zone
     * @param int $hour_start
     * @param int $hour_end
     * @param int $time_zone_offset
     * @return string
     * @throws Exception
     */
    public function createDateTimeForSchedule(int $hour_start, int $hour_end, int $time_zone_offset): string
    {
        $date_starting = gmdate('Y-m-d ' . rand($hour_start, $hour_end) . ':' . rand(10, 59) . ':s');
        $date = new DateTime($date_starting);
        $date->modify('+' . (-1) * $time_zone_offset . ' hours');
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Fills out the schedule of notifications for the current day
     * @throws Exception
     */
    public function generate()
    {
        // every day we will create a schedule for today
        if ('0' != gmdate("G") || '01' != gmdate("i")) {
            die;
        }

        foreach ($this->bd->getSchedule() as $item) {
            // how many notifications to send per day
            for ($i = 0; $i < $item['quantity']; $i++) {
                $this->bd->addSendingDailyNow(
                    [
                        'chat_id' => $item['chat_id'],
                        'date_time' => $this->createDateTimeForSchedule(
                            $item['hour_start'],
                            $item['hour_end'],
                            $item['time_zone_offset']
                        ),
                        'status_sent' => 0,
                    ]
                );
            }
        }
    }
}
