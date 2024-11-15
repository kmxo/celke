<?php

namespace App\adms\Models;

class AdmsLogin
{
    private array $dados;

    public function login(array $data = null)
    {
       $this->data = $data;
       var_dump($this->data);
    }

}
