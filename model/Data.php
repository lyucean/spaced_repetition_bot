<?php

namespace srbot\Model;

use MysqliDb;

class Data
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
    }

    public function getContentPrepared($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        $content = $this->db->get("content");

        // just random text
        return !empty($content) ? $content[array_rand($content)]['text'] : [];
    }

    public function set($chat_id)
    {
        $this->db->where("chat_id", $chat_id);
        $content = $this->db->get("content");

        // just random text
        return !empty($content) ? $content[array_rand($content)]['text'] : [];
    }

    public function getSendingList()
    {
        $this->db->where("date_time", Date('Y-m-d H:i:s'), "<=");
        $this->db->where("status_sent", 0);
        return $this->db->get("schedule_daily");
    }

    public function setScheduleDailyStatusSent($schedule_daily_id)
    {
        $this->db->where('schedule_daily_id', $schedule_daily_id);
        $this->db->update('schedule_daily', ['status_sent' => 1]);
    }

//    public function addContent($data)
//    {
//
//        $this->db->where ("chat_id", 123);
//        $content = $this->db->get ("content");
//
//        $data = Array (
//            'chat_id' => $data['chat_id'],
//            'active' => true,
//            'firstName' => 'John',
//            'lastName' => 'Doe',
//            'date_added' => $db->now(),
//            'date_reminder' => $db->now(),
//        );
//
//        $id = $db->insert ('users', $data);
//
//        if (!$id){
//            echo 'insert failed: ' . $db->getLastError();
//        }
//
//        return $id
//    }
}
