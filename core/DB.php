<?php

namespace srbot\core;

use Exception;
use MysqliDb;

class DB
{
    private $db;

    public function __construct()
    {
        $this->db = new MysqliDb (
            array(
                'host' => DB_HOST,
                'username' => DB_USERNAME,
                'password' => DB_PASSWORD,
                'db' => DB_NAME,
                'port' => DB_PORT,
                'prefix' => '',
                'charset' => 'utf8'
            )
        );

        return $this;
    }

    public function getContentPrepared($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        $this->db->orderBy("date_reminder", "asc");
        $content = $this->db->get("content");

        // just random text
        return !empty($content) ? $content[array_rand($content)] : [];
    }

    public function getSendingDailyNow()
    {
        $this->db->where("date_time", gmdate('Y-m-d H:i:s'), "<=");
        $this->db->where("status_sent", 0);
        return $this->db->get("schedule_daily");
    }

    public function addSendingDailyNow($data)
    {
        return $this->db->insert('schedule_daily', $data);
    }

    public function setScheduleDailyStatusSent($schedule_daily_id)
    {
        $this->db->where('schedule_daily_id', $schedule_daily_id);
        $this->db->update('schedule_daily', ['status_sent' => 1]);
    }

    public function getSchedule()
    {
        return $this->db->get("schedule");
    }

    /**
     * @param $content_id
     * @return bool
     * @throws Exception
     */
    public function deleteContent($content_id)
    {
        $this->db->where('content_id', $content_id);
        return $this->db->delete('content');
    }

    /**
     * Adds content, returns content_id
     * @param $data
     * @return int content_id
     * @throws Exception
     */
    public function addContent($data)
    {
        $data['date_added'] = $this->db->now();
        $data['date_reminder'] = $this->db->now();
        return $this->db->insert('content', $data);
    }

    public function addDateReminderContent($content_id)
    {
        $this->db->where('content_id', $content_id);
        $this->db->update(
            'content',
            [
                'date_reminder' => $this->db->now(),
                'rating' => $this->db->inc()
            ]
        );
    }
}
