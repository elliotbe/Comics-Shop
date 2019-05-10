<?php
declare(strict_types = 1);
namespace App;

class Validator {

  private $data;
  private $errors = [];

  public function __construct(array $form_data) {
    $this->data = $form_data;
  }

  public function isRequired(string $field, string $label = null) :bool {
    $label = is_null($label) ? $field : $label;
    if (empty($this->data[$field])) {
      $this->errors[] = "Le champ '$label' est requis.";
      return false;
    }
    return true;
  }

  public function isEmail(string $field) :bool {
    if (
      $this->isRequired($field) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
      $this->errors[] = "'{$this->data[$field]}' n'est pas un email valide.";
      return false;
    }
    return true;
  }

  public function isMoreThan(string $field, string $value) {
    // TODO maybe
  }


  public function getErrors() :array {
    return $this->errors;
  }



}
