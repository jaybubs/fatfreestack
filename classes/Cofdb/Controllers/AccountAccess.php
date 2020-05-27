<?php

namespace Cofdb\Controllers;
use DB;

//controller to handle registration, login, logout, and/or potentially authentication/authorisation/sessions
class AccountAccess
{
  private $display;
  private $user;
  private $userMap;

  public function __construct($f3)
  {
    global $f3;
    session_start();
    $this->display = new \Cofdb\Controllers\WebPage($f3);
    $this->user = new \Cofdb\Entity\User($f3);
    $this->userMap = new DB\SQL\Mapper($f3->get('DB'),'user');
  }

  public function showRegisterForm($f3)
  {
    $f3->set('output', 'register.htm');
    $this->display->display($f3);
  }

  public function showLoginForm($f3)
  {
    $f3->set('bannerText', $f3->get('SESSION.username'));
    $f3->set('output', 'login.htm');
    $this->display->display($f3);
  }
  public function register($f3)
  {
    //assume data is valid to begin with
    $valid=true;
    //pull all the post data
    $username = $f3->get('POST.username');
    $email = $f3->get('POST.email');
    $confirmEmail = $f3->get('POST.confirm_email');
    $password = $f3->get('POST.password');
    $confirmPassword = $f3->get('POST.confirm_password');
    //create an empty error messages array to be populated
    $errorMessage = array();

    if (empty($username)) {
      $valid=false;
      $errorMessage[] = 'username cannot be empty';
    } elseif ($this->user->checkUser($username) == True) {
      $valid=false;
      $errorMessage[] = 'username already exists';
    }

    if (empty($email)) { 
      $valid=false;
      $errorMessage[] = 'email cannot be empty';
    } elseif ($this->user->checkEmail($email) == True) {
      $valid=false;
      $errorMessage[] = 'email is already registered';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
      $valid=false;
      $errorMessage[] = 'bruh, your email ain\'t valid';
    }

    if ($confirmEmail !== $email) {
      $valid=false;
      $errorMessage[] = 'emails don\'t match';
    }

    if ($confirmPassword !== $password) {
      $valid=false;
      $errorMessage[] = 'passwords don\'t match';
    }

    //if all fields have been checked add user, otherwise display what's wrong
    if ($valid) {
      $f3->mset(array(
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
      ));
      $f3->set('bannerText', 'Welcome '.$username);
      $f3->set('articleText', 'Your account has been registered');
      $f3->set('output', 'home.htm');
      $this->user->addUser($f3);
      $this->display->display($f3);
    } else {
      $f3->set('output', 'register.htm');
      $f3->set('errorMessage', implode('<br>',$errorMessage));
      $this->display->display($f3);
    }


  }

  public function login($f3)
  {
    $username = $f3->get('POST.username');
    $password = $f3->get('POST.password');
    $this->userMap->load(array('username=?',$username));
    $hash = $this->userMap->password;
    $errorMessage = array();

    if (!empty($username) && password_verify($password, $hash)) {
      session_regenerate_id();
      $f3->set('SESSION.username', $username);
      $f3->set('SESSION.password', $hash);
      //maybe review the code to return true/false instead, and have the bulk of teh operation in an accountaccess model instead of here in the controller?
      // return true;
      $f3->set('bannerText', 'Welcome '.$username);
      $f3->set('articleText', 'You have successfully logged in');
      $f3->set('output', 'home.htm');
      $this->display->display($f3);
    } else {
      $errorMessage[] = 'You fucked something up bruv, try again';
      $f3->set('output', 'login.htm');
      $f3->set('errorMessage', implode('<br>',$errorMessage));
      $this->display->display($f3);
    }

  }

  public function isLoggedIn() {
    if (empty($f3->get('SESSION.username'))) {
      return false;
    }
    $seshUsername = $f3->get('SESSION.username');
    $seshPassword = $f3->get('SESSSION.password');
    $hash = $this->user->password;

    if (!empty($seshUsername) && $seshPassword = $hash) {
      $f3->set('loggedin', 'true');
      return true;
    } else {
      return false;
    }
  }


  public function logout($f3)
  {
    session_destroy();
    $f3->set('bannerText', 'You have been logged out successfully');
    $f3->set('output', 'login.htm');
    $this->display->display($f3);
  }

}
