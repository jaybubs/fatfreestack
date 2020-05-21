<?php
namespace Cofdb\Controllers;

class WebPage {

  private function renderTemplate($templateName) {
  echo \Template::instance()->render($templateName);
  }

  public function display($f3) {
    $this->renderTemplate('layout.htm');

  }
  public function home($f3) {
    $f3->set('bannerText', 'Home');
    $f3->set('output', 'home.htm');
    $f3->set('articleText', 'Placeholder text for articleText');
    $this->display($f3);

  }
  public function about($f3) {
    $f3->set('bannerText', 'About');
    $f3->set('output', 'about.htm');
    $this->display($f3);
  }

}
