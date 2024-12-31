<?php

namespace App\adms\Models;

/**
 * Editar usuário no banco de dados
 *
 * @author Celke
 */
class AdmsEditUsers
{
  /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
  private bool $result = false;

  /** @var array|null $resultBd Recebe os registros do banco de dados */
  private array|null $resultBd;

  /** @var int|string|null $id Recebe o id do registro */
  private int|string|null $id;

  /** @var array|null $data Recebe as informações do formulário */
  private array|null $data;

  /** @var array|null $data Recebe os campos que devem ser retirados da validação */
  private array|null $dataExitVal;

  /**
   * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
   */
  function getResult(): bool
  {
      return $this->result;
  }

  /**
   * @return bool Retorna os detalhes do registro
   */
  function getResultBd(): array|null
  {
      return $this->resultBd;
  }

  public function viewUser(int $id): void
  {
      $this->id = $id;

      $viewUser = new \App\adms\Models\helper\AdmsRead();
      $viewUser->fullRead(
          "SELECT id, name, nickname, email, user
                          FROM adms_users
                          WHERE id=:id
                          LIMIT :limit",
          "id={$this->id}&limit=1"
      );

      $this->resultBd = $viewUser->getResult();
      if ($this->resultBd) {
          $this->result = true;
      } else {
          $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
          $this->result = false;
      }
  }

  public function update(array $data = null): void
  {
    //debug = true, para o processamento e exibe var_dump
    //debug = false, nao mostra var_dump e atualiza registro em banco de dados.
    $debug = false;

    $this->data = $data;

    if ($debug) {
      echo "<pre>";
      var_dump($this->data);
      echo "</pre>";
    }


    //Retirando o campo nickname da validacao
    $this->dataExitVal['nickname'] = $this->data['nickname'];
    unset($this->data['nickname']);

    if ($debug) {
      echo "<pre>";
      var_dump($this->data);
      echo "</pre>";
    }

    $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
    $valEmptyField->valField($this->data);
    if ($valEmptyField->getResult()) {

      if ($debug) {
        $this->result = false;
      } else {
        $this->valInput();
        $this->result = true;
      }

    } else {
        $this->result = false;
    }
  }

  /**
   * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
   * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
   * Instanciar o helper "validatePassword" para validar a senha
   * Instanciar o helper "validateUserSingleLogin" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
   * Instanciar o método "add" quando não houver nenhum erro de preenchimento
   * Retorna FALSE quando houve algum erro
   *
   * @return void
   */
  private function valInput(): void
  {
      $valEmail = new \App\adms\Models\helper\AdmsValEmail();
      $valEmail->validateEmail($this->data['email']);

      $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
      $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

      $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
      $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);



      if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
          $this->edit();
      } else {
          $this->result = false;
      }
  }

  private function edit(): void
  {
    $this->data['modified'] = date("Y-m-d H:i:s");

    //Nickname foi retirado da validacao. Devolvendo ao array para gravar no registro.
    $this->data['nickname'] = $this->dataExitVal['nickname'];

    $upUser = new \App\adms\Models\helper\AdmsUpdate();
    $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

    if ($upUser->getResult()){
      $_SESSION['msg'] = "<p style='color: green;'>Usuário alterado com sucesso!</p>";
      $this->result = true;
    }else{
      $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não alterado com sucesso!</p>";
      $this->result = false;
    }
  }


}
