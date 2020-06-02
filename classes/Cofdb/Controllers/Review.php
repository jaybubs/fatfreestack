<?php

namespace Cofdb\Controllers;

class Review
  //controller to add/edit/delete/list reviews, given or not given filters
{
  private $display;
  private $beans;
  private $user;

  public function __construct($f3, $beans, $user)
  {
    global $f3;
    $this->display = new \Cofdb\Controllers\WebPage($f3);
    $this->beans = new \Cofdb\Entity\Coffee($f3);
    $this->user = new \Cofdb\Entity\User($f3);
  }

  public function show($f3, $reviewId)
    //pulls out a singular review
  {
    $reviewId = $f3->get('PARAMS.reviewId');
    // get shit from the coffee entity, the webpage token gives the reviewId directly
    $fields = $this->beans->getReview($f3, $reviewId);
    //this sets 'beansid' f3 hive variable but also local variable so it can be used for accessing image information
    $beansId = $f3->set('beansId', $fields['beansId']);

    $f3->mset(array(
      'title'       => $fields['title'],
      'bannerText'  => $fields['beansName'],
      'user'        => $fields['user'],
      'rating'      => $fields['rating'],
      'reviewText'  => $fields['reviewText'],
      'reviewTitle' => $fields['reviewTitle'],
      'beansImage'  => '../assets/images/beans/'.$beansId.'.jpg',
      'output'      => 'coffee.htm',
    ));

    $this->display->display($f3);
  }

  public function list($f3,$beansId=[])
    //if no beansId is supplied, a list of all reviews should be returned
  {
    $beansId = $f3->get('PARAMS.beansId');
    $reviewItems = $this->beans->listReviews($f3, $beansId);
    $f3->mset(array(
      'title'       => 'Pick your review',
      'bannerText'  => 'Pick your review',
      'beansId'     => $beansId,
      'reviewItems' => $reviewItems,
      'output'      => 'reviewList.htm',
    ));
    $this->display->display($f3);
  }

  public function showReviewForm($f3)
  {
    //comment
    if (!empty($f3->get('SESSION.userId'))) {
      $f3->mset(array(
        'bannerText' => 'Add Review',
        'title' => 'Add Review',
        'output' => 'addReview.htm',
      ));
      $this->display->display($f3);
    } else {
      $f3->reroute('@login');
    }
    //comment
  }

  public function add($f3, $beansId) {
    //call to user model, where a review is added via sql method
    //placeholder comment for user authentication
    $userId      = $f3->get('SESSION.userId');
    $beansId     = $f3->get('POST.beansId');
    $reviewTitle = $f3->get('POST.reviewTitle');
    $reviewText  = $f3->get('POST.reviewText');
    $rating      = $f3->get('POST.rating');
    $valid = true;

    if (empty($beansId)) {
      $valid=false;
      $errorMessage[] = 'Beans Id cannot be empty';
    }

    if (empty($reviewTitle)) {
      $valid=false;
      $errorMessage[] = 'Give your review a title';
    }
    if (empty($reviewText)) {
      $valid=false;
      $errorMessage[] = 'Write a review for the beans';
    }
    if (empty($rating)) {
      $valid=false;
      $errorMessage[] = 'Give your beans a rating between 0 to 10';
    } elseif (filter_var($rating, FILTER_VALIDATE_FLOAT, array(
      'options' => array(
        'min_range' => 0.0,
        'max_range' => 10.0,
      ))) !== False) {
      $valid=false;
      $errorMessage[] = 'Rating must be between 0 and 10';
    }

    if ($valid) {
      $addReview = $f3->mset(array(
        'beansId'     => $beansId,
        'userId'      => $userId,
        'reviewTitle' => $reviewTitle,
        'reviewText'  => $reviewText,
        'rating'      => $rating,
      ));

      $this->user->addReview($f3);

      $f3->mset(array(
        'bannerText' => 'Review Added Succesfully',
        'title' => 'Review Added Succesfully',
        'output' => 'welcome.htm',
      ));
      $this->display->display($f3);
    } else {
      $f3->mset(array(
        'bannerText' => 'Failed to add review',
        'title' => 'Failed to add review',
        'errorMessage' => implode('<br>',$errorMessage),
        'output' => 'addReview.htm',
      ));
      $this->display->display($f3);
    }
  }

}
