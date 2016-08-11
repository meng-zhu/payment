<?php
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei');

class PaymentFlow
{
    public $db;

    /* 建立資料庫連線 */
    public function __construct()
    {
        $dbconnect = 'mysql:host=localhost;dbname=payment;port=3306';
        $dbuser = 'root';
        $dbpw = '';

        /* 連接資料庫伺服器 */
        $this->db = new PDO($dbconnect, $dbuser, $dbpw);
        $this->db->exec('set names utf8');

        echo "<script>console.log('建立資料庫連線--".date('h:i:s')."');</script>";
    }

    /* 關閉資料庫連線 */
    public function __destruct()
    {
        $this->db = NULL;

        echo "<script>console.log('關閉資料庫連線--".date('h:i:s')."');</script>";
    }

    /* 確認餘額  */
    public function checkBalance($account)
    {
        $result = $this->db->prepare('SELECT * FROM `account` WHERE `account` = :account FOR UPDATE');
        $result->bindParam('account', $account);
        $result->execute();
    }

    /* 更新帳戶餘額-入帳(存款) */
    public function deposit($account, $money, $memo, $type)
    {
        $result = $this->db->prepare('UPDATE `account` SET `balance` = `balance` + :money WHERE `account` = :account');
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->execute();
        $this->insertList($account, $money, $memo, $type);

        return $result;
    }

    /* 更新帳戶餘額-出帳(提款) */
    public function withdrawal($account, $money, $memo, $type)
    {
        $getBalance = $this->getBalance($account);

        /* 取得餘額以確保可以正確提款 */
        $balance = $getBalance[0]['balance'];

        $check = $balance - $money;
        if($check < 0 ){
            return false;
        }

        $result = $this->db->prepare('UPDATE `account` SET `balance` = `balance` - :money WHERE `account` = :account');
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->execute();
        $this->insertList($account, $money, $memo, $type);

        return $result;
    }

    /* 新增出入帳紀錄 */
    public function insertList($account, $money, $memo, $type)
    {
        $datetime = date ('Y-m-d H:i:s');
        $getBalance = $this->getBalance($account);

        /* 取得本次紀錄完成後的餘額 */
        $balance = $getBalance[0]['balance'];

        $result = $this->db->prepare('INSERT INTO `payment_flow`(`money`, `account`, `date`, `memo`, `type`, `balance`) VALUES (:money, :account, :date, :memo, :type, :balance)');
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('date', $datetime);
        $result->bindParam('memo', $memo);
        $result->bindParam('type', $type);
        $result->bindParam('balance', $balance);
        $result->execute();

        return $result;
    }

    /* 查詢帳戶餘額 */
    public function getBalance($account)
    {
        $result = $this->db->prepare('SELECT * FROM `account` WHERE `account` = :account');
        $result->bindParam('account', $account);
        $result->execute();
        $result = $result->fetchAll();

        return $result;
    }

    /* 查詢帳戶明細 */
    public function getList($account)
    {
        $result = $this->db->prepare('SELECT * FROM `payment_flow` WHERE `account` = :account ORDER BY `date` ASC');
        $result->bindParam('account', $account);
        $result->execute();
        $result = $result->fetchAll();

        return $result;
    }
}
