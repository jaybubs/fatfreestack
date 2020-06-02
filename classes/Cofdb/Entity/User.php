<?php

namespace Cofdb\Entity;
use DB;

class User
{
  const ARTICLE_POST = 1;
  const ARTICLE_EDIT = 2;
  const ARTICLE_DELETE = 4;
  const EDIT_USER_ACCESS = 8;
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
    $email    = $f3->get('email');
    $password = $f3->get('password');

    $db = $f3->get('DB');
    $db->exec('INSERT INTO user VALUES (
      null,
      :username,
      :email,
      :password)',
      array(
        ':username' => $username,
        ':email'    => $email,
        ':password' => $password
      ));
  }

  public function addReview($f3) {
    $userId      = $f3->get('userId');
    $beansId     = $f3->get('beansId');
    $reviewTitle = $f3->get('reviewTitle');
    $reviewText  = $f3->get('reviewText');
    $rating      = $f3->get('rating');

    $db = $f3->get('DB');
    $db->exec('INSERT INTO review VALUES (
      null,
      :user_id,
      :beans_id,
      :review_title,
      :review_text,
      :rating)',
      array(
        ':user_id'      => $userId,
        ':beans_id'     => $beansId,
        ':review_title' => $reviewTitle,
        ':review_text'  => $reviewText,
        ':rating'       => $rating,
      ));
  }

}
