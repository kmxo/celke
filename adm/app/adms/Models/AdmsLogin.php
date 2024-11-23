<?php

namespace App\adms\Models;

class AdmsLogin
{
    private array|null $data;
    private $resultBd;
    private $result;

    function getResult(){
        return $this->result;
    }

    public function login(array $data = null)
    {
        $this->data = $data;
        //var_dump($this->data);  

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        // Retorna todas as colunas
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->data['user']}&limit=1");

        // Retorna somente as colunas indicadas
        $viewUser->fullRead("SELECT id, name, nickname, email, password, image FROM adms_users WHERE user =:user LIMIT :limit", "user={$this->data['user']}&limit=1");

        $this->resultBd = $viewUser->getResult();
        if($this->resultBd){
            //var_dump($this->resultBd);
            $this->valPassword();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }

    private function valPassword()
    {
        if(password_verify($this->data['password'], $this->resultBd[0]['password'])){
            //$_SESSION['msg'] = "<p style='color: green;'>Login realizado com sucesso!</p>";
            $_SESSION['user_id'] = $this->resultBd[0]['id'];
            $_SESSION['user_name'] = $this->resultBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultBd[0]['email'];
            $_SESSION['user_image'] = $this->resultBd[0]['image'];
            $this->result = true;
            //echo $_SESSION['msg'];
        }else{
            //$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha incorreta!</p>";
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
            //echo $_SESSION['msg'];
        }
    }
}