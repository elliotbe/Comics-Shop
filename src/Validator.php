<?php
declare(strict_types = 1);
namespace App;

class Validator {

  private $data;
  private $errors = [];
  private $method_array;
  private $label = [
    'email' => 'Email',
    'password' => 'Mot de Passe',
    'password_confirm' => 'Confirmer le mot de passe'
  ];


  public function __construct(array $form_data) {
    $this->data = $form_data;
  }


  public function try(string $method_name, ...$method_args) {
    $this->method_array[] = [
      'name' => $method_name,
      'args' => $method_args
    ];
    return $this;
  }


  public function run(string $field) {
    foreach ($this->method_array as $method) {
      array_unshift($method['args'], $field);
      $isInvalid = call_user_func_array([$this, $method['name']], $method['args']) === false;
      if ($isInvalid) {
        $_POST[$field] = '';
        unset($this->method_array);
        return false;
      }
    }
    unset($this->method_array);
    return true;
  }

  public function getErrors() :array {
    return $this->errors;
  }


  public function isRequired(string $field) {
    $label = $this->label[$field] ?? ucfirst($field);
    if (!empty($this->data[$field])) {
      return true;
    }
    $this->errors[] = "Le champ $label est requis";
    return false;
  }


  public function isEmail(string $field) {
    if (filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
      return true;
    }
    $this->errors[] = "{$this->data[$field]} n'est pas un email valide";
    return false;
  }


  public function isConfirmed(string $field) :bool {
    if ($this->data[$field] === $this->data["{$field}_confirm"]) {
      return true;
    }
    $_POST["{$field}_confirm"] = '';
    $label = $this->label[$field] ?? ucfirst($field);
    $label_confirm = $this->label["{$field}_confirm"] ?? ucfirst($field);
    $this->errors[] = "Les champs $label et $label_confirm ne correspondent pas";
    return false;
  }


  public function isUniq(string $field) :bool {
    $user = \App::getModel('User')->getByEmail($this->data[$field]);
    if ($user === false) {
      return true;
    }
    if ($field === 'email') {
      $this->errors[] = "Il existe déja un compte avec l'adresse {$this->data[$field]}";
    } else {
      $label = $this->label[$field] ?? ucfirst($field);
      $this->errors[] = "Le champ $label n'est pas unique";
    }
    return false;
  }


  public function isMoreThan(string $field, int $value) :bool {
    if (strlen($this->data[$field]) >= $value) {
      return true;
    }
    $label = $this->label[$field] ?? ucfirst($field);
    $this->errors[] = "Le champ $label doit faire au moins $value caractères";
    return false;
  }


  public function isLessThan(string $field, int $value) :bool {
    if (strlen($this->data[$field]) <= $value) {
      return true;
    }
    $label = $this->label[$field] ?? ucfirst($field);
    $this->errors[] = "Le champ $label doit faire moins de $value caractères";
    return false;
  }


  public function isBetween(string $field, int $more_than, int $less_than) :bool {
    if (strlen($this->data[$field]) >= $more_than && strlen($this->data[$field]) <= $less_than) {
      return true;
    }
    $label = $this->label[$field] ?? ucfirst($field);
    $this->errors[] = "Le champ $label doit faire entre $more_than et $less_than caractères";
    return false;
  }

}
