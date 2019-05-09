<?php
namespace App;

class Auth {

  public function isLoggedIn() :bool {
    return (bool)\App::session()->get('auth');
  }

  public function getUserId() :int {
    return \App::session()->get('auth')['user_id'];
  }

  public function login($id) :void {
    if (!$this->isLoggedIn()) {
      \App::session()->set('auth', [
        'user_id' => $id
      ]);
      \App::basket()->mergeBasketFromDb();
      sendBack();
    }
  }

  public function logout() :void {
    if ($this->isLoggedIn()) {
      \App::basket()->deleteBasket();
      \App::session()->set('auth', null);
      sendBack();
    }
  }

}
