<?php

class Controller {
    
    public function model($model) {
        require_once "../payment/models/$model.php";
        return new $model();
    }
    
    public function view($view, $data = Array()) {
        require_once "../payment/views/$view.php";
    }
}

?>