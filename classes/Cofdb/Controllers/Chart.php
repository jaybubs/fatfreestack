<?php

namespace Cofdb\Controllers;
class Chart {

  private $display;

  public function __construct($f3)
  {
    global $f3;
    $this->display = new \Cofdb\Controllers\WebPage($f3);
  }
  

  public function showChart($f3)
  {
    $f3->mset(array(
      'bannerText' => 'Here be a chart',
      'title' => 'Chart',
      'output' => 'chart.htm',
    ));
    $this->display->display($f3);
  }

}
