<?php
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei');
class PaymentFlow
{
    public $db;

    /* 建立資料庫連線 */
    public function __construct()
    {
        $dbconnect = "mysql:host=localhost;dbname=payment;port=3306";
        $dbuser = "root";
        $dbpw = "";
        // 連接資料庫伺服器
        $this->db = new PDO($dbconnect, $dbuser, $dbpw);
        $this->db->exec("set names utf8");
        echo "<script>console.log('建立資料庫連線--".date("h:i:s")."');</script>";
    }

    /* 關閉資料庫連線 */
    public function __destruct()
    {
        $this->db = NULL;
        echo "<script>console.log('關閉資料庫連線--".date("h:i:s")."');</script>";
    }

    /* 確認餘額  */
    public function checkBalance($account)
    {
        $result = $this->db->prepare("SELECT * FROM `account` WHERE `account` = :account FOR UPDATE");
        $result->bindParam('account', $account);
        $result->execute();
    }

    /* 新增入帳紀錄 */
    public function insertEarn($account, $money, $memo)
    {
        $datetime = date ("Y- m - d / H : i : s");
        $result = $this->db->prepare("INSERT INTO `payment_flow`( `money`, `account`, `date`, `memo`) VALUES (:money, :account, :date, :memo)");
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('date', $datetime);
        $result->bindParam('memo', $memo);
        $result->execute();
        return $result;
    }

    /* 更新帳戶餘額-入帳 */
    public function earnMoney($account, $money, $memo)
    {
        $this->insertEarn($account, $money, $memo);
        $result = $this->db->prepare("UPDATE `account` SET `balance` = `balance` + :money WHERE `account` = :account");
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->execute();
        return $result;
    }

    /* 新增出帳紀錄 */
    public function insertPay($account, $money, $memo)
    {   $datetime = date ("Y- m - d / H : i : s");
        $money = "-".$money;
        $result = $this->db->prepare("INSERT INTO `payment_flow`( `money`, `account`, `date`, `memo`) VALUES (:money, :account, :date, :memo)");
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('date', $datetime);
        $result->bindParam('memo', $memo);
        $result->execute();
        return $result;
    }

    /* 更新帳戶餘額-出帳 */
    public function payMoney($account, $money, $memo)
    {
        $this->insertPay($account, $money, $memo);
        $result = $this->db->prepare("UPDATE `account` SET `balance` = `balance` - :money WHERE `account` = :account");
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->execute();
        return $result;
    }

    /* 查詢帳戶餘額 */
    public function accountBalance($account)
    {
        $result = $this->db->prepare("SELECT * FROM `account` WHERE `account` = :account");
        $result->bindParam('account', $account);
        $result->execute();
        return $result;
    }

    /* 查詢帳戶明細 */
    public function accountShowPayMent($account)
    {
        $result = $this->db->prepare("SELECT * FROM `payment_flow` WHERE `account` = :account");
        $result->bindParam('account', $account);
        $result->execute();
        return $result;
    }
}
