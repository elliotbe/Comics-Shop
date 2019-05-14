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
    $this->loadModel('User');
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
   * @route '/mon-compte'
   */

  public function account() {
    $this->auth->restrict();
    $errors = [];
    // $this->Order->getLast($user_id, 5); // TODO
    if (!empty($_POST)) {
      $validator = new Validator($_POST);
      $validator->try('isRequired')->try('isEmail')->run('email');
      $validator->try('isRequired')->try('isMoreThan', 4)->run('first_name');
      $errors = $validator->getErrors();
    }
    $user = array_merge($this->session->get('auth'), array_filter($_POST));
    $user_id = $user['user_id'];
    if (!empty($_POST) && empty($errors)) {
      $this->auth->changeAccountInfo($user);
    }
    $form = new Form($user);
    $this->render('user/account', compact('errors', 'form', 'user_id'), 'Mon compte');
  }


  /**
   * @route changer-de-mot-de-passe
   */

  public function changePassword() {
    $this->auth->restrict();
    $validator = new Validator($_POST);
    // $validator->try('isRequired')->try('isMoreThan', 4)->try('isConfirmed')->run('new_password');
    $errors = $validator->getErrors();
    if (!empty($errors)) {
      $this->session->setFlash('error', $errors[0]);
      redirect('/mon-compte');
    }
    $this->auth->changePassword((int)$_GET['id'], $_POST);
  }


  /**
   * @route '/supprimer-le-compte
   */

  public function suppressAccount() {
    $this->auth->restrict();
    $validator = new Validator($_POST);
    $errors = $validator->getErrors();
    if (!empty($errors)) {
      $this->session->setFlash('error', $errors[0]);
      redirect('/mon-compte');
    }
    $this->auth->deleteAccount((int)$_GET['id'], $_POST['password']);
  }


  /**
   * @route '/deconnexion'
   */

  public function logout() {
    $this->auth->logout();
    $this->session->setFlash('success', "Vous êtes maintenant déconnecté. À bientôt!");
    redirect('/');
  }

}
