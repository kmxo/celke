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

      //Recebe os dados vindos do formulario
      $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

      if ((!empty($id)) and (empty($this->dataForm['SendEditUser']))) {
          $this->id = (int) $id;
          $viewUser = new \App\adms\Models\AdmsEditUsers();
          $viewUser->viewUser($this->id);
          if($viewUser->getResult()){
            $this->data['form'] = $viewUser->getResultBd();
            // echo "<pre>";
            // var_dump($this->data['form'][0]['email']);
            // var_dump($this->data['form']);
            // echo "</pre>";
            $this->viewEditUser();

          } else {
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
          }
          //Para visualizar os dados, preciso criar uma model. ex: AdmsEditUsers.php

      } else {
          /*$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
          $urlRedirect = URLADM . "list-users/index";
          header("Location: $urlRedirect");*/
          $this->editUser();

      }

    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     *
     */
    private function viewEditUser(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editUser", $this->data);
        $loadView->loadView();
    }

    private function editUser(): void
    {
      // echo "<pre>";
      // var_dump($this->dataForm);
      // echo "</pre>";
      if (!empty($this->dataForm['SendEditUser'])){
        //Nao existe no banco de dados um campo com este nome. Destruir.
        unset($this->dataForm['SendEditUser']);
        $editUser = new \App\adms\Models\AdmsEditUsers();
        $editUser->update($this->dataForm);
        if ($editUser->getResult()){
          $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
          header("Location: $urlRedirect");
        }else{
          //Preserva os valores vindos do formulario
          $this->data['form'] = $this->dataForm;
          //Carrega a view
          $this->viewEditUser();
        }
      }else{
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
      }
    }
}
