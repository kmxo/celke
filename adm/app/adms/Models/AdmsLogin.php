<?php

namespace App\adms\Models;

class AdmsLogin
{
    private array $dados;

    public function login(array $data = null)
    {
       $this->data = $data;
       // var_dump($this->data);

       $connect = new \App\adms\Models\helper\AdmsConn();
       $conn = $connect->connectDb();
       var_dump($conn);
    }

}
