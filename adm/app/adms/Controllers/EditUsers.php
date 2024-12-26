<?php

namespace App\adms\Controllers;

/**
 * Controller da página editar usuário
 * @author Cesar <cesar@celke.com.br>
 */
class EditUsers
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     *
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

      //echo "Editar o usuario<br>";
      if (!empty($id)) {
          $this->id = (int) $id;
          $viewUser = new \App\adms\Models\AdmsEditUsers();
          $viewUser->viewUser($this->id);
          if($viewUser->getResult()){
            $this->data['form'] = $viewUser->getResultBd();
            var_dump($this->data['form']);
          }
          //Para visualizar os dados, preciso criar uma model. ex: AdmsEditUsers.php

      } else {
          $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
          $urlRedirect = URLADM . "list-users/index";
          header("Location: $urlRedirect");
      }

    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     *
     */
    private function viewEditUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/addUser", $this->data);
        $loadView->loadView();
    }
}
