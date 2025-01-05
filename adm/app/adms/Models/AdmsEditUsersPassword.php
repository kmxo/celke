<?php

namespace App\adms\Models;

/**
 * Editar a senha do susuário no banco de dados
 *
 * @author Celke
 */
class AdmsEditUsersPassword
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
          "SELECT id
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

    if ($debug){
      echo '<pre>';
      var_dump($this->data);
      echo '</pre>';
    }

    if ($debug){
      echo '<pre>';
      var_dump($this->data);
      echo '</pre>';
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
   * Instanciar o helper "AdmsValPassword" para validar a senha
   * Retorna FALSE quando houve algum erro
   *
   * @return void
   */
  private function valInput(): void
  {

      $valPass = new \App\adms\Models\helper\AdmsValPassword();
      $valPass->validatePassword($this->data['password']);

      if ( $valPass->getResult() ) {
          $this->edit();
      } else {
          $this->result = false;
      }
  }

  private function edit(): void
  {
    $this->data['modified'] = date("Y-m-d H:i:s");
    $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);

    $upUser = new \App\adms\Models\helper\AdmsUpdate();
    $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

    if ($upUser->getResult()){
      $_SESSION['msg'] = "<p style='color: green;'>A senha do Usuário alterado com sucesso!</p>";
      $this->result = true;
    }else{
      $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha do Usuário não alterado com sucesso!</p>";
      $this->result = false;
    }
  }


}
