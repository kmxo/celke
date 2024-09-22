<?php

namespace App\adms\Controllers;

/**
 * Controller da página login
 * @author Cesar <cesar@celke.com.br>
 */
class Login
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = null;

    /** @var array|null $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        
        if (!empty($this->dataForm['SendLogin'])){
            //var_dump($this->dataForm);
            $this->data['form'] = $this->dataForm;
        }

        //$this->data = null;

        $loadView = new \Core\ConfigView("adms/Views/login/login", $this->data);
        $loadView->loadView();
    }
}
