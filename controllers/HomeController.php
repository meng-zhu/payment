<?php

class HomeController extends Controller
{
    /**
     * 跳轉到 主頁面(index.php) 頁面
     */
    public function index()
    {
        $this->view("index");
    }

    /**
     * 跳轉到 出款(payMoney.php) 頁面
     */
    public function payMoney()
    {
        $this->view("payMoney");
    }

    /**
     * 跳轉到 入款(earnMoney.php) 頁面
     */
    public function earnMoney()
    {
        $this->view("earnMoney");
    }
}
