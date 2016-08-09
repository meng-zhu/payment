<?php
class PaymentFlowController extends Controller
{
    public function checkAccount($account)
    {
        $check = $this->model("Account");
        $checkAccount = $check->checkAccount($account);
        return $checkAccount;
    }
    
    public function money()
    {   
        $type = $_GET['type'];
        $account = $_GET['account'];
        $money = $_GET['money'];
        /* 先確認是否有此帳號 */
        $checkAccount = $this->checkAccount($account);
        if ($checkAccount) {
            try {
                $paymentFlow = $this->model("PaymentFlow");
                $paymentFlow->db->beginTransaction();
                // sleep(5);
                /* 執行 row lock */
                $paymentFlow->checkBalance($account);
                // sleep(10);
                if ($type == 1) {
                    $result = $paymentFlow->paymentFlowPayMoney($account,$money);
                    if ($result) {
                        $showInfo = "交易完成，已成功付出款項";    
                    } else {
                        $showInfo = "交易失敗，請在試一次";
                        throw new Exception($showInfo);
                    }
                } else {
                    $result = $paymentFlow->paymentFlowEearnMoney($account,$money);
                    if ($result) {
                        $showInfo = "交易完成，已成功存入戶頭";    
                    } else {
                        $showInfo = "交易失敗，請在試一次";
                        throw new Exception($showInfo);
                    }
                }
                $paymentFlow->db->commit();
            } catch(Exception $showInfo) {
                $paymentFlow->db->rollback();
                $this->view("showinformation",$showInfo-＞getMessage());
            }
           
            
        } else {
            $showInfo = "帳號輸入錯誤";
        }
        $this->view("showinformation",$showInfo);
    }
    
    public function showPayMent()
    {   
        $account = $_GET['account'];
        /* 先確認是否有此帳號 */
        $checkAccount = $this->checkAccount($account);
        if ($checkAccount) {
            $paymentFlow = $this->model("PaymentFlow");
            $resultBalance = $paymentFlow->accountBalance($account);
            $resultAll = $paymentFlow->accountShowPayMent($account);
            $this->view("balance",$resultBalance,$resultAll);
        } else {
            $showInfo = "帳號輸入錯誤";
            $this->view("showinformation",$showInfo);
        }
    }
}
