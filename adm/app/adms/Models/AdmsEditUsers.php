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

}
