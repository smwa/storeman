<?php

class Session extends MysqlActiveRecord {
    protected function getPrimaryKey() {
        return "id";
    }
    protected function getTableName() {
        return "sessions";
    }

    protected function getRelations() {
        return array(
            "User" => array(
                "relation" => self::belongsTo,
                "model"     => "User",
                "localkey" => "userid",
                "foreignkey" => "id"
            ),
        );
    }

    public $id,
        $userid,
        $sessionid,
        $lastactiontime;
  
  function __construct() {
        $this->sessionid = self::generateId();
        $this->lastactiontime = date("Y-m-d H:i:s");
        parent::__construct();
    }
    
    public static function generateId() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < 64; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }
    
    private static function clearOldSessions() {
        $sessions = self::find(array("lastactiontime" => "< ".date("Y-m-d H:i:s", strtotime("-24 hours"))));
        foreach ((array)$sessions as $session) {
            $session->delete();
        }
    }
    
    public static function getUserIDBySessionID($sid) {
        self::clearOldSessions();
        $user = self::findOne(array("sessionid" => $sid));
        if ($user) {
            $user->lastactiontime = date("Y-m-d H:i:s");
            $user->save();
            return $user->userid;
        }
        return 0;
    }
}
