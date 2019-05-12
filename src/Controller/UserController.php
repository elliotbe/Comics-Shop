<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Validator;
use App\HTML\Form;


class UserController extends Controller {

  private $auth;
  private $session;


  public function __construct() {
    parent::__construct();
    $this->auth = \App::auth();
    $this->session = \App::session();
  }

  /**
   * @route '/inscription'
   */

  public function register() {
    $errors = [];
    if (!empty($_POST)) {
      $validator = new Validator($_POST);
      $validator->try('isRequired')->try('isEmail')->try('isUniq')->run('email');
      $validator->try('isRequired')->try('isMoreThan', 4)->try('isConfirmed')->run('password');
      $validator->try('isRequired')->try('isMoreThan', 4)->run('password_confirm');
      $errors = $validator->getErrors();
    }
    if (!empty($_POST) && empty($errors)) {
      $this->auth->register((object)$_POST);
    }
    $form = new Form($_POST);
    $this->render('/user/register', compact('errors', 'form'), 'Inscription');
  }


  /**
   * @route '/connexion'
   */

  public function login() {
    $errors = [];
    if (!empty($_POST)) {
      $validator = new Validator($_POST);
      $validator->try('isRequired')->try('isEmail')->run('email');
      $validator->try('isRequired')->try('isMoreThan', 4)->run('password');
      $errors = $validator->getErrors();
    }
    if (!empty($_POST) && empty($errors)) {
      $this->auth->login((object)$_POST);
    }
    $form = new Form($_POST);
    $this->render('/user/login', compact('errors', 'form'), 'Connexion');
  }


  /**
   * @route '/confirmation'
   */

  public function confirm() {
    $this->auth->confirm((int)$_GET['id'], $_GET['token']);
  }


  /**
   * @route '/renvoi-confirmation'
   */

  public function resendConfirm() {
    $this->auth->resendConfirm((int)$_GET['id']);
  }


  /**
   * @route '/oubli-du-mot-de-passe'
   */
  public function forgetPassword() {
    $errors = [];
    if (!empty($_POST)) {
      $validator = new Validator($_POST);
      $validator->try('isRequired')->try('isEmail')->run('email');
      $errors = $validator->getErrors();
    }
    if (!empty($_POST) && empty($errors)) {
      $this->auth->forgetPassword($_POST['email']);
    }
    $form = new Form($_POST);
    $this->render('/user/forget', compact('errors', 'form'), 'Mot de passe oublié');
  }


  /**
   * @route '/reinitialisation-du-mot-de-passe'
   */

  public function resetPassword() {
    $errors = [];
    if (isset($_GET['id']) && isset($_GET['token'])) {
      $this->auth->checkResetToken((int)$_GET['id'], $_GET['token']);
    }
    if (!empty($_POST)) {
      $validator = new Validator($_POST);
      $validator->try('isRequired')->try('isMoreThan', 4)->try('isConfirmed')->run('password');
      $validator->try('isRequired')->try('isMoreThan', 4)->run('password_confirm');
      $errors = $validator->getErrors();
    }
    if (!empty($_POST) && empty($errors)) {
      $this->auth->resetPassword((int)$_GET['id'], $_POST['password']);
    }
    $form = new Form($_POST);
    $this->render('user/reset', compact('errors', 'form'), 'Réinitialiser votre mot de passe');
  }


  /**
   * @route '/deconnexion'
   */

  public function logout() {
    $this->auth->logout();
    $this->session->setFlash('success', "Vous êtes maintenant déconnecté. À bientôt!");
    sendBack();
  }

}
