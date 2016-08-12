<?php
date_default_timezone_set('Asia/Taipei');

class PaymentFlow
{
    public $db;

    /**
     * 建立資料庫連線
     */
    public function __construct()
    {
        $dbConnect = 'mysql:host=localhost;dbname=payment;port=3306';
        $dbUser = 'root';
        $dbPw = '';

        // 連接資料庫伺服器
        $this->db = new PDO($dbConnect, $dbUser, $dbPw);
        $this->db->exec('set names utf8');

        echo "<script>console.log('建立資料庫連線--".date('h:i:s')."');</script>";
    }

    /**
     * 關閉資料庫連線
     */
    public function __destruct()
    {
        $this->db = null;

        echo "<script>console.log('關閉資料庫連線--".date('h:i:s')."');</script>";
    }

    /**
     * 更新帳戶餘額-入帳(存款)
     */
    public function deposit($account, $money, $memo, $type)
    {
        $getBalance = $this->getBalance($account);

        $version = $getBalance[0]['version'];

        $sql = 'UPDATE `account` SET `balance` = `balance` + :money, `version` = `version` + 1 WHERE `account` = :account AND `version` = :version';
        $result = $this->db->prepare($sql);
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('version', $version);

        // 執行並取得影響行數
        $count = $result->rowCount($result->execute());

        if(!$count){
            return false;
        }

        $this->insertList($account, $money, $memo, $type);

        return $result;
    }

    /**
     * 更新帳戶餘額-出帳(提款)
     */
    public function withdrawal($account, $money, $memo, $type)
    {
        $getBalance = $this->getBalance($account);

        $version = $getBalance[0]['version'];

        $sql = 'UPDATE `account` SET `balance` = `balance` - :money, `version` = `version` + 1  WHERE `account` = :account AND `version` = :version';
        $result = $this->db->prepare($sql);
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('version', $version);

         // 執行並取得影響行數
        $count = $result->rowCount($result->execute());

        if(!$count){
            return false;
        }

        $this->insertList($account, $money, $memo, $type);

        return $result;
    }

    /**
     * 新增出入帳紀錄
     */
    public function insertList($account, $money, $memo, $type)
    {
        $datetime = date ('Y-m-d H:i:s');
        $getBalance = $this->getBalance($account);

        // 取得本次紀錄完成後的餘額
        $balance = $getBalance[0]['balance'];

        $sql = 'INSERT INTO `payment_flow`
            (`money`, `account`, `date`, `memo`, `type`, `balance`) VALUES
            (:money, :account, :date, :memo, :type, :balance)';
        $result = $this->db->prepare($sql);
        $result->bindParam('money', $money);
        $result->bindParam('account', $account);
        $result->bindParam('date', $datetime);
        $result->bindParam('memo', $memo);
        $result->bindParam('type', $type);
        $result->bindParam('balance', $balance);
        $result->execute();

        return $result;
    }

    /**
     * 查詢帳戶餘額
     */
    public function getBalance($account)
    {
        $sql = 'SELECT * FROM `account` WHERE `account` = :account';
        $result = $this->db->prepare($sql);
        $result->bindParam('account', $account);
        $result->execute();

        $result = $result->fetchAll();

        return $result;
    }

    /**
     * 查詢帳戶明細
     */
    public function getList($account)
    {
        $sql = 'SELECT * FROM `payment_flow` WHERE `account` = :account ORDER BY `date` ASC';
        $result = $this->db->prepare($sql);
        $result->bindParam('account', $account);
        $result->execute();
        $result = $result->fetchAll();

        return $result;
    }
}
