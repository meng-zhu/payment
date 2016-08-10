<?php
header("Content-Type:text/html; charset=utf-8");
class Account
{
    public $db;

    /* 建立資料庫連線 */
    public function __construct()
    {
        $dbconnect = 'mysql:host=localhost;dbname=payment;port=3306';
        $dbuser = 'root';
        $dbpw = '';
        // 連接資料庫伺服器
        $this->db = new PDO($dbconnect, $dbuser, $dbpw);
        $this->db->exec("set names utf8");
    }

    /* 關閉資料庫連線 */
    public function __destruct()
    {
        $this->db = NULL;
    }

    /* 確認是否有此帳戶 */
    public function checkAccount($account)
    {
        $result = $this->db->prepare('SELECT * FROM `account` WHERE `account` = :account');
        $result->bindParam('account', $account);
        $result->execute();
        $row = $result->fetchAll();

        if (!count($row)) {
            return false;
        }
        return true;
    }
}
