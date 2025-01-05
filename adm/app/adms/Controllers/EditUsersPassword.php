<?php

namespace App\adms\Controllers;

/**
 * Controller da página editar senha do usuário
 * @author Cesar <cesar@celke.com.br>
 Para criar a funcionalidade Editar Senha do Usuario eu
 1 Criei essa Controller
 2 Em CarregarPgAdm, colocar essa pagina na lista de paginas privadas
 3 Posso tentar acessar direto ou posso criar um link em uma View existente
   Nesse exemplo, colocamos o link em viewUser
 4 Criar uma nova models AdmsEditUserPassword.php
 5 Criar uma nova view editUserPass.php acertando campos e alterando o form id

 6 Retirar required da view e validar form via Javascript (form id)

 7 Alterar nome da classe no metodo editUser
 8 Implementar o metodo update na Models
   Seta debug=true para testar no browser as validacoes
   Para isso eh necessario comentar as validaçoes JavaScript

 */
class EditUsersPassword
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
          $viewUserPass = new \App\adms\Models\AdmsEditUsersPassword();
          $viewUserPass->viewUser($this->id);
          if($viewUserPass->getResult()){
            $this->data['form'] = $viewUserPass->getResultBd();
            // echo "<pre>";
            // var_dump($this->data['form'][0]['email']);
            // var_dump($this->data['form']);
            // echo "</pre>";
            $this->viewEditUserPass();

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
    private function viewEditUserPass(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editUserPass", $this->data);
        $loadView->loadView();
    }

    private function editUser(): void
    {
      // echo "<pre>";
      // var_dump($this->dataForm);
      // echo "</pre>";
      if (!empty($this->dataForm['SendEditUserPass'])){
        //Nao existe no banco de dados um campo com este nome. Destruir.
        //Eh o nome do botao submit da view
        unset($this->dataForm['SendEditUserPass']);
        $editUserPass = new \App\adms\Models\AdmsEditUsersPassword();
        $editUserPass->update($this->dataForm);
        if ($editUserPass->getResult()){
          $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
          header("Location: $urlRedirect");
        }else{
          //Preserva os valores vindos do formulario
          $this->data['form'] = $this->dataForm;
          //Carrega a view
          $this->viewEditUserPass();
        }
      }else{
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
      }
    }
}
