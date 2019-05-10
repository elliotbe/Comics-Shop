<?php
namespace App;

class Auth {

  private $user_model;
  private $session;
  private $cookie_name = 'comics-shop_remember';

  public function __construct(Session $session) {
    $this->user_model = \App::getModel('User');
    $this->session = $session;
  }

  public function isLoggedIn() :bool {
    return (bool)\App::session()->get('auth');
  }

  public function getUserId() :int {
    return $this->session->get('auth')->user_id;
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
      redirect('/connexion');
      return false;
    }

    if (!password_verify($form_data->password, $user->password)) {
      $this->session->setFlash('error', "Le mot de passe est invalide.");
      redirect('/connexion');
      return false;
    }

    if (!$user->registration_token) {
      $this->session->setFlash('error', "Veuillez comfirmer votre compte. <a class=\"flash-msg__link\" href=\"foo\">Renvoyer l'email</a>");
      redirect('/connexion');
      return false;
    }

    if ($form_data->remember) {
      $this->setRememberToken($user->user_id);
    }


    if ($this->isLoggedIn()) {
      $this->logout();
    }

    $this->session->set('auth', $user);
    \App::basket()->mergeBasketFromDb();
    sendBack();
    return true;
  }


  public function setRememberToken(int $user_id) :void {
    $remember_token = generateToken(60);
    $this->user_model->upsert(['remember_token' => $remember_token], $user_id);
    $cookie_token = $user_id . '==' . $remember_token;
    setcookie($this->cookie_name, $cookie_token, time() + 3600 * 24 * 7, '/');
  }


  public function connectFromCookie() :bool {
    if (!$this->isLoggedIn() && isset($_COOKIE[$this->cookie_name])) {
      // \App::basket()->setBasketFromDb();
      return true;
    }
    return false;
  }

  public function logout() :void {
    \App::basket()->deleteBasket();
    \App::session()->set('auth', null);
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
