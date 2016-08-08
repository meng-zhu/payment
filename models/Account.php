<?php
header("Content-Type:text/html; charset=utf-8");
class Account
{
    protected $DB;
    public function __construct()
    {
        $DBCONNECT = "mysql:host=localhost;dbname=payment;port=443";
        $DBUSER = "root";
        $DBPW = "";
        // 連接資料庫伺服器
        $this->DB = new PDO($DBCONNECT, $DBUSER, $DBPW);
        $this->DB->exec("set names utf8");
    }
    function __destruct()
    {
        $this->DB = NULL;
    }
    public function check_account($ACCOUNT)
    {
        $RESULT =  $this->DB->prepare("SELECT * FROM `account` WHERE `account` = ?");
        $RESULT->execute(array($ACCOUNT));//依序取代sql中"?"的值，並執行
        $ROW = $RESULT->fetchAll();
        if(count($ROW)<1){
            return false;
        }else{
            return true;
        }
    }
}
?>
