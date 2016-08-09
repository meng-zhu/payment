<?php
header("Content-Type:text/html; charset=utf-8");
class Account
{
    public $db;
    
    public function __construct()
    {
        $dbconnect = "mysql:host=localhost;dbname=payment;port=443";
        $dbuser = "root";
        $dbpw = "";
        // 連接資料庫伺服器
        $this->db = new PDO($dbconnect, $dbuser, $dbpw);
        $this->db->exec("set names utf8");
    }
    
    public function __destruct()
    {
        $this->db = NULL;
    }
    
    public function checkAccount($account)
    {
        $result = $this->db->prepare("SELECT * FROM `account` WHERE `account` = ?");
        $result->execute(array($account));//依序取代sql中"?"的值，並執行
        $row = $result->fetchAll();
        if (count($row)<1) {
            return false;
        } else {
            return true;
        }
    }
}
