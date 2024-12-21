<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe genérica para enviar e-mail
 *
 * @author Celke
 */
class AdmsSendEmail
{
    /** @var array $data Receber as informações do conteúdo do e-mail */
    private array $data;

    /** @var array $dataInfoEmail Receber as credenciais do e-mail */
    private array $dataInfoEmail;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    public function sendEmail(): void
    {
        $this->dataInfoEmail['host'] = "smtp.mailtrap.io";
        $this->dataInfoEmail['fromEmail'] = "atendimento@celke.com.br";
        $this->fromEmail = $this->dataInfoEmail['fromEmail'];
        $this->dataInfoEmail['fromName'] = "Celke";
        $this->dataInfoEmail['username'] = "ed12dd02941308";
        $this->dataInfoEmail['password'] = "3c0bf6100311cd";
        $this->dataInfoEmail['port'] = 587;

        $this->data['toEmail'] = "cesar@celke.com.br";
        $this->data['toName'] = "Cesar";
        $this->data['subject'] = "Confirma e-mail";
        $this->data['contentHtml'] = "Olá <b>Cesar</b><br><p>Cadastro realizado com sucesso!</p>";
        $this->data['contentText'] = "Olá Cesar \n\nCadastro realizado com sucesso!";

        $this->sendEmailPhpMailer();
    }

    private function sendEmailPhpMailer(): void
    {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $this->dataInfoEmail['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->dataInfoEmail['username'];
            $mail->Password   = $this->dataInfoEmail['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->dataInfoEmail['port'];

            $mail->setFrom($this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);
            $mail->addAddress($this->data['toEmail'], $this->data['toName']);

            $mail->isHTML(true);
            $mail->Subject = $this->data['subject'];
            $mail->Body    = $this->data['contentHtml'];
            $mail->AltBody = $this->data['contentText'];

            $mail->send();

            $this->result = true;
        } catch (Exception $e) {
            $this->result = false;
        }
    }
}
