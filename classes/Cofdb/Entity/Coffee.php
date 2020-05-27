<?php

namespace Cofdb\Entity;
use DB;

class Coffee
{
  private $beansMap;
  private $reviewMap;
  private $tableName;

  public function __construct()
  {
    global $f3;
    //use mappers for passive retrieval
    $this->beansMap = new DB\SQL\Mapper($f3->get('DB'),'beans');
    $this->reviewMap = new DB\SQL\Mapper($f3->get('DB'),'review');
  }
  
  public function getReview($f3, $reviewId)
  {
    //code to fetch article from DB, requires DB connection
    //load the array into memory based on the reviewId
    $this->reviewMap->load(array('review_id=?',$reviewId));
    //get beansId based on the review to fetch their info
    $beansId = $this->reviewMap->beans_id;
    //now that we have beansId, load the array into memory based on the id just like we did above
    $this->beansMap->load(array('beans_id=?',$beansId));
    //access individual items from the loaded arrays
    $beansName = $this->beansMap->beans_name;
    $title = $this->beansMap->beans_name;
    $reviewText = $this->reviewMap->review_text;
    $reviewTitle = $this->reviewMap->review_title;
    $user = $this->reviewMap->user_id;
    $rating = $this->reviewMap->rating;
    //return array so it can be used in view
    return [
      'beansName' => $beansName,
      'title' => $title,
      'reviewText' => $reviewText,
      'reviewTitle' => $reviewTitle,
      'user' => $user,
      'rating' => $rating,
      'beansId' => $beansId,
    ];
  }
  
  public function listReviews($f3, $beansId=[])
  {
    //if a beansId is supplied, fetch only reviews for that particular beansId, otherwise return all reviews available
    //TODO: paginate/categorise results
    if (!$beansId==[]) {
      $db = $f3->get('DB');
      $reviewItems = $db->exec('SELECT review_id, review_title FROM review where beans_id=:beansId',array(':beansId'=>$beansId));
    } else {
    $db = $f3->get('DB');
    $reviewItems = $db->exec('SELECT review_id, review_title FROM review');
    }
    return $reviewItems;
  }
  
  
  public function topFour($f3)
  {
    $db = $f3->get('DB');
    //the absolute fucking state of sql statements
    //average review rating per bean_id to find the top four, group by the bean_id itself and find the matching bean_name from the beans table
    $rows = $db->exec('SELECT review.beans_id, review.review_id, avg(review.rating), beans.beans_name FROM review LEFT JOIN beans on review.beans_id=beans.beans_id GROUP BY review.beans_id ORDER BY avg(review.rating) DESC LIMIT 4 ');
    return $rows;
  }
  
}
