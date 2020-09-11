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
    $f3->mset(array(
      'bannerText' => 'REGISTER YOURSELF FUCKING HELL',
      'title' => 'Registration',
      'output' => 'register.htm',
    ));
    $this->display->display($f3);
  }

  public function showLoginForm($f3)
  {
    $f3->set('bannerText', 'Login ¯\_(ツ)_/¯');
    $f3->set('title', 'login');
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
      $f3->set('bannerText', 'Account '.$username.' registered, please log in');
      $f3->set('title', 'registration');
      $f3->set('output', 'login.htm');
      $this->user->addUser($f3);
      $this->display->display($f3);
    } else {
      $f3->set('output', 'register.htm');
      $f3->set('bannerText', 'Registration FAILED MISERABLY');
      $f3->set('title', 'registration failed');
      $f3->set('errorMessage', implode('<br>',$errorMessage));
      $this->display->display($f3);
    }


  }

  public function login($f3)
  {
    //get deets from the form
    $username = $f3->get('POST.username');
    $password = $f3->get('POST.password');
    $this->userMap->load(array('username=?',$username));
    $hash = $this->userMap->password;
    $userId = $this->userMap->user_id;

    //check whether the submitted data matches the stuff in the user db
    if (!empty($username) && password_verify($password, $hash)) {
      session_regenerate_id(); //prevent session hijacking
      $f3->set('SESSION.userId', $userId);
      $f3->set('SESSION.username', $username);
      $f3->set('SESSION.password', $hash);
      //maybe review the code to return true/false instead, and have the bulk of teh operation in an accountaccess model instead of here in the controller?
      // return true;
      $f3->set('bannerText', 'Welcome '.$username. ' your userId is '.$userId);
      $f3->set('title', 'Welcome');
      $f3->set('articleText', 'You have successfully logged in');
      $f3->set('output', 'welcome.htm');
      $this->display->display($f3);
    } else {
      //figure out how to limit the number of attempts - slap a number of attempts column into the user db maybe? this way destroying cache/session won't reenable it for the atemptee
      $f3->set('output', 'login.htm');
      $f3->set('bannerText', 'Login FAILED MISERABLY');
      $f3->set('title', 'login failed');
      $f3->set('errorMessage', 'You fucked something up bruv, try again');
      $this->display->display($f3);
    }

  }


  public function logout($f3)
  {
    session_destroy();
    $f3->set('title', 'goodbye');
    $f3->set('bannerText', 'Goodbye '.$f3->get('SESSION.username'));
    $f3->set('SESSION.username','');
    $f3->set('SESSION.password','');
    $f3->set('output', 'login.htm');
    $this->display->display($f3);
  }

}
