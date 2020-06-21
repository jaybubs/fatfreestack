<?php
namespace Cofdb;
// include __DIR__.'/../../includes/dbconxn.php';
$CC = 'Cofdb\Controllers\\';

// $f3->route('GET @about: /about', $CC.'WebPage->about');
$f3->route('GET @about: /about', function($f3) { echo phpinfo(); });
// $f3->route('GET /coffee', $CC.'Coffee->show');
$f3->route('GET /coffee/@beansId', $CC.'Review->list');
$f3->route('GET /review/@reviewId', $CC.'Review->show');
$f3->route('GET @review: /review', $CC.'Review->list');
$f3->route('GET @addReview: /addReview', $CC.'Review->showReviewForm');
$f3->route('GET @register: /register', $CC.'AccountAccess->showRegisterForm');
$f3->route('GET @login: /login', $CC.'AccountAccess->showLoginForm');
$f3->route('GET @logout: /logout', $CC.'AccountAccess->logout');
$f3->route('POST /reviewSubmit', $CC.'Review->add');
$f3->route('POST /registerSubmit', $CC.'AccountAccess->register');
$f3->route('POST /loginSubmit', $CC.'AccountAccess->login');

$f3->route(array(
  'GET /',
  'GET /home',
  'GET /index',
  'GET /coffee',
), $CC.'Coffee->home');
