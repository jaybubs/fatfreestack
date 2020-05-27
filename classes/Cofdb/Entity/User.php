<?php

namespace Cofdb\Entity;
use DB;

class User
{
  private $userMap;

  public function __construct()
  {
    global $f3;
    $this->userMap = new DB\SQL\Mapper($f3->get('DB'),'user');
  }

  public function checkUser($username) {
    $this->userMap->load(array('username=?', $username));
    if ($this->userMap->username == $username) {
      return True;
    } 
  }

  public function checkEmail($email) {
    $this->userMap->load(array('email=?', $email));
    if ($this->userMap->email== $email) {
      return True;
    } 
  }

  public function addUser($f3)
  {
    //values order: user_id, username, email, password

    $username = $f3->get('username');
    $email = $f3->get('email');
    $password = $f3->get('password');

    $db = $f3->get('DB');
    $db->exec('INSERT INTO user VALUES (
      null,
      :username,
      :email,
      :password)',
      array(
        ':username' => $username,
        ':email' => $email,
        ':password' => $password));
  }

}
