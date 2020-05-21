<?php

namespace Cofdb\Controllers;
use DB;

class Coffee
{
  private $display;
  private $beans;

  public function __construct($display, $beans)
  {
    $this->display = new \Cofdb\Controllers\WebPage($f3);
    $this->beans = new \Cofdb\Entity\Coffee($f3);
  }

  public function home($f3) {
    $f3->set('bannerText', 'Home');
    $f3->set('articleText', 'Welcome Home');
    //get the top four rated coffees, the entity takes care of the db thingy, might play around with more later
    $rows = $this->beans->topFour($f3);
    $f3->set('beanAttributes', $rows);
    $f3->set('output', 'home.htm');
    $this->display->display($f3);

  }
  public function show($f3,$beansId)
  {
    $beansId = $f3->get('PARAMS.beansId');
    // get shit from coffee controller, id is set as the webpage token
    $fields = $this->beans->getArticle($f3,$beansId);
    $f3->set('title', $fields['title']);
    $f3->set('author', $fields['author']);
    $f3->set('bannerText', $fields['beansName']);
    $f3->set('rating', '10');
    $f3->set('articleText', $fields['articleText']);
    //create a  pointer for the image
    
    $f3->set('beansImage', '../assets/images/beans/'.$beansId.'.jpg');
    $f3->set('output', 'coffee.htm');
    $this->display->display($f3);
  }
}
