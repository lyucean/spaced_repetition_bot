<?php

namespace srbot\core;

use Exception;
use MysqliDb;

class DB
{
    private MysqliDb $db;

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

    // SendingDaily ---------------------------------------------------
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


    // Schedule ---------------------------------------------------
    public function getSchedules()
    {
        return $this->db->get("schedule");
    }

    public function getSchedule($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        return $this->db->getOne("schedule");
    }

    public function setSchedule($chat_id, $data)
    {
        if (!empty($data['quantity'])) {
            $change['quantity'] = (int)$data['quantity'];
        }

        if (!empty($data['time_zone_offset'])) {
            $change['time_zone_offset'] = (int)$data['time_zone_offset'];
        }

        if (empty($change)) {
            return;
        }

        $change['chat_id'] = $chat_id;
        $change['date_modified'] = $this->db->now();

        $this->db->replace('schedule', $change);
    }

    // Content ----------------------------------------------------
    public function getContentPrepared($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        $this->db->orderBy("date_reminder", "asc");
        $content = $this->db->get("content");

        // just random text
        return !empty($content) ? $content[array_rand($content)] : [];
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

    /**
     * update date reminder and rating for Content
     * @param $content_id
     * @throws Exception
     */
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

    // ChatHistory ------------------------------------------------
    public function addChatHistory($data)
    {
        $data['date_added'] = $this->db->now();
        $this->db->insert('chat_history', $data);
    }

    // WaitingCommand ---------------------------------------------
    public function getWaitingCommand($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        return $this->db->getOne("command_waiting", 'command');
    }

    public function cleanWaitingCommand($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        return $this->db->delete('command_waiting');
    }

    public function setWaitingCommand($chat_id, $command)
    {
        $this->db->replace(
            'command_waiting',
            [
                'chat_id' => $chat_id,
                'date_added' => $this->db->now(),
                'command' => $this->db->escape($command)
            ]
        );
    }
}
