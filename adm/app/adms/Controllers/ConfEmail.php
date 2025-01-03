<?php

namespace App\adms\Controllers;

/**
 * Controller da página Confirmar Email
 * @author Cesar <cesar@celke.com.br>
 */
class ConfEmail
{

    /** @var string|null $key Recebe a chave para confirmar o cadastro */
    private string|null $key;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);

        if (!empty($this->key)) {
            $this->valKey();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valKey(): void
    {
        $confEmail = new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->key);
        if ($confEmail->getResult()) {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
