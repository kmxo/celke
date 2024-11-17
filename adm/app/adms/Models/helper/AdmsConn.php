<?php

namespace App\adms\Models\helper;

use PDO;
use PDOException;

class AdmsConn
{
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbname = DBNAME;
    private string $port = PORT;
    private object $connect;

    public function connectDb(): object
    {
       try {
           // Conexao
           $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=" .
            $this->dbname, $this->user, $this->pass);

            return $this->connect;

       } catch (PDOException $err) {
             die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
       }

    }

}
