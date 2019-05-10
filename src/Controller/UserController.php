<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Validator;
use App\HTML\Form;


class UserController extends Controller {

  private $auth;
  private $form_data;

  public function __construct() {
    parent::__construct();
    $this->auth = \App::auth();
    $this->form_data = $_POST;
  }

  public function login() {
    $errors = [];
    $form = new Form($this->form_data);
    if (!empty($this->form_data)) {
      $validator = new Validator($this->form_data);
      $validator->isEmail('email');
      $validator->isRequired('password', 'mot de passe');
      $errors = $validator->getErrors();
    }
    if (!empty($this->form_data) && empty($errors)) {
      $this->auth->login((object)$this->form_data);
    }
    $this->render('/user/login', compact('errors', 'form'), 'Connexion');
  }

  public function register() {
    return 'register user';
  }

}
