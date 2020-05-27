<?php
namespace Cofdb\Controllers;

class WebPage {

  private $accountAccess;

  public function __construct($f3)
  {
    global $f3;
  }
  
  private function renderTemplate($templateName) {
  echo \Template::instance()->render($templateName);
  }

  public function display($f3) {
    $this->renderTemplate('layout.htm');

  }

  public function about($f3) {
    $f3->set('bannerText', 'About');
    $f3->set('output', 'about.htm');
    $this->display($f3);
  }

}
