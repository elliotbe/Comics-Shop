<?php
declare(strict_types = 1);
namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer extends PHPMailer {

  /**
   * Constructor function
   * @param boolean $exceptions throw errors if true
   */

  public function __construct(bool $exceptions = null) {
    parent::__construct($exceptions);
    $this->isSMTP();
    $this->Host = \App::config()->get('SMTP_HOST');
    $this->SMTPAuth = true;
    $this->Username = \App::config()->get('SMTP_USERNAME');
    $this->Password = \App::config()->get('SMTP_PASSWORD');
    $this->SMTPSecure = 'tls';
    $this->Port = 465;
    $this->isHTML(true);
    $this->CharSet = 'UTF-8';
    $this->setFrom('no-reply@comics-shop.fr');
  }


  /**
   * Send a mail to confirm user account
   * @param string $email
   * @param integer $user_id
   * @param string $token
   * @return boolean
   */

  public function sendConfirm(string $email, int $user_id, string $token) :bool {
    $this->addAddress($email);
    $this->Subject = 'Confirmation de votre compte';
    ob_start();
    require(ROOT . 'extra/mail_template/confirm.php');
    $this->Body = ob_get_clean();
    return parent::send();
  }


  /**
   * Send a mail to reset user password
   * @param string $email
   * @param integer $user_id
   * @param string $token
   * @return boolean
   */

  public function sendReset(string $email, int $user_id, string $token) :bool {
    $this->addAddress($email);
    $this->Subject = 'Réinitialisation du mot de passe';
    ob_start();
    require(ROOT . 'extra/mail_template/reset.php');
    $this->Body = ob_get_clean();
    return parent::send();
  }

}
