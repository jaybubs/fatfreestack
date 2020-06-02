<?php

namespace Cofdb\Controllers;
use DB;

class Coffee
{
  private $display;
  private $beans;
  private $accountAccess;

  public function __construct($display)
  {
    global $f3;
    $this->display = new \Cofdb\Controllers\WebPage($f3);
    $this->beans = new \Cofdb\Entity\Coffee($f3);
    $this->accountAccess = new \Cofdb\Controllers\AccountAccess($f3);
  }

  public function home($f3) {
    //get the top four rated coffees, the entity takes care of the db thingy, might play around with more later
    $rows = $this->beans->topFour($f3);
    $f3->mset(array(
    'bannerText'     => 'Welcome Home '.$f3->get('SESSION.username'),
    'articleText'    => 'Welcome Home',
    'title'          => 'Welcome Home',
    'beanAttributes' => $rows,
    'output'         => 'home.htm',
    ));
    $this->display->display($f3);

  }


}
