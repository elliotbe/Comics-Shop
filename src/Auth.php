<?php
namespace App;

use App\Model\UserModel;


/**
 * A class to deal with user registration, authentification, etc
 */

class Auth {

  private $user_model;
  private $session;
  private $basket;
  private $mailer;
  private $cookie_name = 'comics-shop_remember';
  private $cookie_duration = 3600 * 24 * 7;


  /**
   * Constructor function
   *
   * @param UserModel $user_model
   * @param Session $session
   * @param Basket $basket
   * @param Mailer $mailer
   */

  public function __construct(UserModel $user_model, Session $session, Basket $basket, Mailer $mailer) {
    $this->user_model = $user_model;
    $this->session = $session;
    $this->basket = $basket;
    $this->mailer = $mailer;
  }


  /**
   * Register a new user
   * @param object $form_data
   * @return boolean
   */

  public function register(object $form_data) :bool {
    $password = $this->hashPassword($form_data->password);
    $registration_token = generateToken(60);
    $this->user_model->upsert([
      'email' => $form_data->email,
      'password' => $password,
      'registration_token' => $registration_token
    ]);

    $user_id = $this->user_model->getLastId();
    $isMailSent = $this->mailer->sendConfirm($form_data->email, $user_id, $registration_token);
    if ($user_id === 0 ||  $isMailSent === false) {
      $this->user_model->delete($user_id);
      return false;
    }

    $this->session->setFlash('success', 'Un email de confirmation vous a été envoyé.');
    sendBack();
    return true;
  }


  /**
   * Log in the user
   * @param object $form_data
   * @return boolean
   */

  public function login(object $form_data) :bool {
    $form_data->remember = isset($form_data->remember);
    $user = $this->user_model->getByEmail($form_data->email);

    if (!$user) {
      $this->session->setFlash('error', 'Email inconnu.');
      unset($_POST['email']);
      return false;
    }

    if (!password_verify($form_data->password, $user->password)) {
      $this->session->setFlash('error', "Le mot de passe est invalide.");
      unset($_POST['password']);
      return false;
    }

    if (!$user->registred_at) {
      $this->session->setFlash('error',
        "Veuillez comfirmer votre compte.
        <a class=\"flash-msg__link\" href=\"/renvoi-confirmation?id=$user->user_id\">
          Renvoyer l'email
        </a>"
      );
      return false;
    }

    if ($form_data->remember) {
      $this->setRememberToken($user->user_id);
    }


    if ($this->isLoggedIn()) {
      $this->logout();
    }

    $this->session->set('auth', $user);
    $this->session->setFlash('success', "Vous êtes bien connecté. Bonjour !");
    $this->basket->mergeBasketFromDb();
    sendBack();
    return true;
  }


  /**
   * Set a cookie during a week used to relog the user
   * @param integer $user_id
   * @return void
   */

  public function setRememberToken(int $user_id) :void {
    $remember_token = generateToken(60);
    $this->user_model->upsert(['remember_token' => $remember_token], $user_id);
    $cookie_token = $user_id . '##' . $remember_token;
    Cookie::set($this->cookie_name, $cookie_token, $this->cookie_duration);
  }


  /**
   * Relog the user if the required cookie match the one in database
   * @return boolean
   */

  public function connectFromCookie() :bool {
    if (!$this->isLoggedIn() && Cookie::get($this->cookie_name)) {
      $remember_token = Cookie::get($this->cookie_name);
      $parts = explode('##', $remember_token);
      $user_id = $parts[0];
      $user = $this->user_model->getOne($user_id);

      if (!$user) {
        Cookie::delete($this->cookie_name);
        return false;
      }

      $expected = "{$user_id}##{$user->remember_token}";
      if (!($expected === $remember_token)) {
        Cookie::delete($this->cookie_name);
        return false;
      }

      Cookie::set($this->cookie_name, $remember_token, $this->cookie_duration);
      $this->session->set('auth', $user);
      $this->basket->setBasketFromDb();
      return true;
    }

    return false;
  }


  /**
   * Confirm the user account from email
   * @param integer $user_id
   * @param string $token
   * @return boolean
   */

  public function confirm(int $user_id, string $token) :bool {
    $user = $this->user_model->getOne($user_id);
    if ($user === false || $user->registration_token !== $token) {
      $this->session->setFlash('error', "Confirmation du compte impossible.");
      sendBack();
      return false;
    }

    $this->user_model->upsert([
      'registration_token' => null,
      'registred_at' => date("Y-m-d H:i:s")
    ], $user_id);
    $this->session->set('auth', $user);
    $this->session->setFlash('success', "Votre compte est maintenant validé. Bonjour !");
    $this->basket->mergeBasketFromDb();
    sendBack();
    return true;
  }


  /**
   * Resend the registration token via mail
   * @param integer $user_id
   * @return bool
   */

  public function resendConfirm(int $user_id) :bool {
    $user = $this->user_model->getOne($user_id);
    if ($user === false || $user->registred_at !== null) {
      $this->session->setFlash('error', "Le mail de confirmation n'a pas pu vous être renvoyée.");
      sendBack();
      return false;
    }
    $registration_token = generateToken(60);
    $this->user_model->upsert(['registration_token' => $registration_token], $user_id);
    $this->mailer->sendConfirm($user->email, $user_id, $registration_token);
    $this->session->setFlash('success', "Un mail de confirmation vous à été renvoyée.");
    sendBack();
    return true;
  }


  /**
   * Send a mail allowing the user to reset his password
   * @param string $email
   * @return boolean
   */
  public function forgetPassword(string $email) :bool {
    $user = $this->user_model->getByEmail($email);
    if ($user === false || $user->registred_at === null)  {
      $this->session->setFlash('error', 'Aucun compte ne correspond à cette adresse');
      return false;
    }
    $reset_token = generateToken(60);
    $this->user_model->upsert([
      'reset_token' => $reset_token,
      'reseted_at' => date("Y-m-d H:i:s")
    ], $user->user_id);
    $this->mailer->sendReset($user->email, $user->user_id, $reset_token);
    $this->session->setFlash('success', "Un mail vous à été envoyé pour changer votre mot de passe.");
    redirect('/connexion');
    return true;
  }

  public function checkResetToken(int $user_id, string $reset_token) {
    $user = $this->user_model->getOne($user_id);
    $interval = strtotime(date("Y-m-d H:i:s")) - strtotime($user->reseted_at);
    if ($user === false || $user->reset_token !== $reset_token) {
      $this->session->setFlash('error', 'Réinitialisation du mot de passe impossible.');
      sendBack();
      return false;
    }
    if ($interval > 1800) {
      $this->session->setFlash('error', 'Réinitialisation du mot de passe impossible. Le mail a expiré');
      sendBack();
      return false;
    }
    return true;
  }


  /**
   * Reset the user password and connect him
   * @param integer $user_id
   * @param string $password
   * @return void
   */

  public function resetPassword(int $user_id, string $password) :void {
    $this->user_model->upsert([
      'password' => $this->hashPassword($password),
      'reseted_at' => null,
      'reset_token' => null,
    ], $user_id);
    $user = $this->user_model->getOne($user_id);
    $this->session->set('auth', $user);
    $this->session->setFlash('success', "Votre mot de passe a bien été modifié.");
    $this->basket->mergeBasketFromDb();
    sendBack();
  }


  /**
   * Disconnect the user
   * @return void
   */

  public function logout() :void {
    Cookie::delete($this->cookie_name);
    $this->basket->eraseBasket();
    $this->session->set('auth', null);
  }


  /**
   * Check if the user is logged in
   * @return boolean
   */

  public function isLoggedIn() :bool {
    return (bool)$this->session->get('auth');
  }


  /**
   * Check if the user has administrator privilege
   * @return boolean
   */

  public function isAdmin() :bool {
    return $this->isLoggedIn() && $this->session->get('auth')->privilege === 'admin';
  }


  /**
   * Return the user id
   * @return integer
   */

  public function getUserId() :int {
    return $this->session->get('auth')->user_id;
  }


  /**
   * Restrict people not logged in from accessing certain pages
   * @return void
   */

  public function restrict() :void {
    if(!$this->isLoggedIn()) {
      $this->session->setFlash('error', "Veuillez vous <a class=\"flash-msg__link\" href=\"/connexion\">connecter</a> pour accéder à cette page.");
      sendBack();
    }
  }


  /**
   * Restrict non admin user from accessing certain pages
   * @return void
   */

  public function restrictNotAdmin() :void {
    if(!$this->isAdmin()) {
      $this->session->setFlash('error', 'Vous ne pouvez pas accéder à cette page.');
      sendBack();
    }
  }


  /**
   * Return the hashed password
   * @param string $password
   * @return string
   */

  public function hashPassword(string $password) :string {
    return password_hash($password, PASSWORD_BCRYPT);
  }

}
