<?php

namespace App\adms\Controllers;

/**
 * Controller da página login
 * @author Cesar <cesar@celke.com.br>
 */
class Login
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        echo "Pagina de login<br>";

        $this->data = null;

        $loadView = new \Core\ConfigView("adms/Views/login/login", $this->data);
        $loadView->loadView();
    }
}
