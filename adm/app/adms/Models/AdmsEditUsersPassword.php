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
      $viewUser->fullRead("SELECT usr.id
                            FROM adms_users AS usr
                            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_level_id
                            WHERE usr.id=:id AND lev.order_levels >:order_levels
                            LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

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
    $this->data = $data;

    $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
    $valEmptyField->valField($this->data);
    if ($valEmptyField->getResult()) {
        $this->valInput();
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
