<?php
class PaymentFlowController extends Controller
{
    /* 確認是否有此帳戶 */
    public function checkAccount($account)
    {
        $check = $this->model("Account");
        $checkAccount = $check->checkAccount($account);
        return $checkAccount;
    }

    /* 出入款操作 */
    public function money()
    {
        $type = $_POST['type'];
        $account = $_POST['account'];
        $money = $_POST['money'];
        $memo = $_POST['memo'];
        /* 先確認是否有此帳號 */
        $checkAccount = $this->checkAccount($account);
        if ($checkAccount) {
            try {
                $paymentFlow = $this->model("PaymentFlow");
                $paymentFlow->db->beginTransaction();
                /* 執行 row lock */
                $paymentFlow->checkBalance($account);
                sleep(10);
                /* type: 1 = 出款 ; 2 = 入款 */
                if ($type == 1) {
                    $result = $paymentFlow->payMoney($account, $money, $memo);
                    if ($result)
                        $showInfo = "交易完成，已成功付出款項";
                } else {
                    $result = $paymentFlow->earnMoney($account, $money, $memo);
                    if ($result)
                        $showInfo = "交易完成，已成功存入戶頭";
                }
                $paymentFlow->db->commit();
            } catch(PDOException $showInfo) {
                $paymentFlow->db->rollback();
                $showInfo = "交易失敗，請在試一次";
                $this->view("showinformation", $showInfo-＞getMessage());
            }
        } else {
            $showInfo = "帳號輸入錯誤";
        }
        $this->view("showinformation",$showInfo);
    }

    /* 查看帳戶餘額及明細 */
    public function showPayMent()
    {
        $account = $_POST['account'];
        /* 先確認是否有此帳號 */
        $checkAccount = $this->checkAccount($account);
        if ($checkAccount) {
            $paymentFlow = $this->model("PaymentFlow");
            $resultBalance = $paymentFlow->accountBalance($account);
            $resultAll = $paymentFlow->accountShowPayMent($account);
            $this->view("balance", $resultBalance, $resultAll);
        } else {
            $showInfo = "帳號輸入錯誤";
            $this->view("showinformation", $showInfo);
        }
    }
}
