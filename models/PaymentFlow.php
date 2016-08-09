<?php
header("Content-Type:text/html; charset=utf-8");
class PaymentFlow
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
    public function checkBalance($ACCOUNT)
    {
        $RESULT = $this->DB->prepare("SELECT * FROM `account` WHERE `account` = ? FOR UPDATE");
        $RESULT->execute(array($ACCOUNT));//依序取代sql中"?"的值，並執行
    }
    public function paymentFlow_insertEarn($ACCOUNT,$MONEY)
    {
        $RESULT = $this->DB->prepare("INSERT INTO `payment_flow`(`money`,`account`) VALUES (?,?)");
        $RESULT->execute(array($MONEY,$ACCOUNT));//依序取代sql中"?"的值，並執行
        return true;    
    }
    public function paymentFlowEearnMoney($ACCOUNT,$MONEY)
    {   
        $this->paymentFlow_insertEarn($ACCOUNT,$MONEY);
        $RESULT = $this->DB->prepare("UPDATE `account` SET `balance`= `balance`+? WHERE `account` = ?");
        $RESULT->execute(array($MONEY,$ACCOUNT));//依序取代sql中"?"的值，並執行
        return true;    
    }
    public function paymentFlow_insertPay($ACCOUNT,$MONEY)
    {   
        $MONEY = "-".$MONEY;
        $RESULT = $this->DB->prepare("INSERT INTO `payment_flow`(`money`,`account`) VALUES (?,?)");
        $RESULT->execute(array($MONEY,$ACCOUNT));//依序取代sql中"?"的值，並執行
        return true;    
    }
    public function paymentFlowPayMoney($ACCOUNT,$MONEY)
    {   
        $this->paymentFlow_insertPay($ACCOUNT,$MONEY);
        $RESULT = $this->DB->prepare("UPDATE `account` SET `balance`= `balance`-? WHERE `account` = ?");
        $RESULT->execute(array($MONEY,$ACCOUNT));//依序取代sql中"?"的值，並執行
        return true;    
    }
    public function AccountBalance($ACCOUNT)
    {
        $RESULT = $this->DB->prepare("SELECT * FROM `account` WHERE `account` = ?");
        $RESULT->execute(array($ACCOUNT));//依序取代sql中"?"的值，並執行
        return $RESULT; 
    }
    public function AccountShowPayMent($ACCOUNT)
    {   
        $RESULT = $this->DB->prepare("SELECT * FROM `payment_flow` WHERE `account` = ?");
        $RESULT->execute(array($ACCOUNT));//依序取代sql中"?"的值，並執行
        return $RESULT; 
    }
}
?>
