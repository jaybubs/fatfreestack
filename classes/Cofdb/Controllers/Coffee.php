<?php

namespace Cofdb\Controllers;
use DB;

class Coffee
{
  private $display;
  private $beans;
  private $accountAccess;

  public function __construct($display, $beans)
  {
    $this->display = new \Cofdb\Controllers\WebPage($f3);
    $this->beans = new \Cofdb\Entity\Coffee($f3);
    $this->accountAccess = new \Cofdb\Controllers\AccountAccess($f3);
  }

  public function home($f3) {
    // if ($this->accountAccess->isLoggedIn()) {
    //   $f3->set('isLoggedIn', True);
    //   $f3->set('bannerText', 'Welcome Home '.$f3->get('SESSION.username'));
    // }
    // $f3->set('bannerText', 'Home');
    $f3->set('articleText', 'Welcome Home');
    //get the top four rated coffees, the entity takes care of the db thingy, might play around with more later
    $rows = $this->beans->topFour($f3);
    $f3->set('beanAttributes', $rows);
    $f3->set('output', 'home.htm');
    $this->display->display($f3);

  }
  public function show($f3, $reviewId)
  {
    $reviewId = $f3->get('PARAMS.reviewId');
    // get shit from the coffee entity, the webpage token gives the reviewId directly
    $fields = $this->beans->getReview($f3, $reviewId);
    //mset is multi-set, instead of having a single line for every attribute, they can all be accessed from an mset array
    $f3->mset(array(
      'title'=> $fields['title'],
      'user'=> $fields['user'],
      'bannerText'=> $fields['beansName'],
      'rating'=> $fields['rating'],
      'reviewText'=> $fields['reviewText'],
      'reviewTitle'=> $fields['reviewTitle'],
    ));
    //this sets 'beansid' f3 hive variable but also local variable so it can be used for accessing image information
    $beansId = $f3->set('beansId', $fields['beansId']);
    $f3->set('beansImage', '../assets/images/beans/'.$beansId.'.jpg');
    $f3->set('output', 'coffee.htm');
    $this->display->display($f3);
  }

  public function reviewPick($f3,$beansId=[])
  {
    //if no beansId is supplied, a list of all reviews should be returned
    $beansId = $f3->get('PARAMS.beansId');
    $reviewItems = $this->beans->listReviews($f3, $beansId);
    $f3->set('beansId', $beansId);
    $f3->set('reviewItems', $reviewItems);
    $f3->set('output', 'reviewPick.htm');
    $this->display->display($f3);
  }
  
}
