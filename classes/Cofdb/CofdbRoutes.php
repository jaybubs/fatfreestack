<?php
namespace Cofdb;
// include __DIR__.'/../../includes/dbconxn.php';
$CC = 'Cofdb\Controllers\\';

$f3->route('GET /about', $CC.'WebPage->about');
$f3->route('GET /coffee', $CC.'Coffee->show');
$f3->route('GET /coffee/@beansId', $CC.'Coffee->show');
$f3->route('GET @testpage: /testpage',$CC.'WebPage->display');
$f3->route(array(
  'GET /',
  'GET /home',
  'GET /index',
  'GET /coffee',
), $CC.'Coffee->home');

