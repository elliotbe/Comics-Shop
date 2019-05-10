<?php
declare(strict_types = 1);
namespace App\Entity;

class UserEntity extends Entity {

  // TODO check for a date object

  public function __construct() {
    $this->user_id = (int)$this->user_id;
  }

  /** @var int $user_id */
  public $user_id;

  /** @var string $email */
  public $email;

  /** @var string $password */
  public $password;

  /** @var string $first_name */
  public $first_name;

  /** @var string $last_name */
  public $last_name;

  /** @var string $address */
    public $address;

  /** @var string $zip_code */
  public $zip_code;

  /** @var string $city */
  public $city;

  /** @var string $registred_at */
  public $registred_at;

  /** @var string $registration_token */
  public $registration_token;

  /** @var string $reseted_at */
  public $reseted_at;

  /** @var string $reset_token */
  public $reset_token;

  /** @var string $remember_token */
  public $remember_token;

  /** @var string $privilege */
  public $privilege;

}
