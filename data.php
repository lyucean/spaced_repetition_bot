<?php

/**
 * Class Data
 */
class Data
{

    private $list = [];
    private $chat_id;
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

        return !empty($content) ? [array_rand($content)] : [];
    }

    public function getChatId()
    {
        return $this->chat_id;
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
