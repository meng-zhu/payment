<?php

class App
{
    /**
     * 將網址拆解的結果進行加工並確實導向controller中的function執行
     */
    public function __construct()
    {
         $url = $this->parseUrl();

         $controllerName = "{$url[0]}Controller";

         if (!file_exists("controllers/$controllerName.php")) {
             header("location:https://missing-meng-zhu.c9users.io/payment/Home");
         }

         require_once "controllers/$controllerName.php";
         $controller = new $controllerName;
         $methodName = isset($url[1]) ? $url[1] : "index";

         if (!method_exists($controller, $methodName)) {
            header("location:https://missing-meng-zhu.c9users.io/payment/Home");
         }

         unset($url[0]); unset($url[1]);
         $params = $url ? array_values($url) : array();
         call_user_func_array(array($controller, $methodName), $params);
    }

    /**
     * 將網址進行拆解
     */
    public function parseUrl()
    {
        if (isset($_GET["url"])) {
            $url = rtrim($_GET['url'],"/");
            $url = explode("/",$url);

            return $url;
        }
    }
}
