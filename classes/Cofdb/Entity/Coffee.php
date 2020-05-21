<?php

namespace Cofdb\Entity;
use DB;

class Coffee
{
  private $map;

  public function __construct($map)
  {
    global $f3;
    $this->map = new DB\SQL\Mapper($f3->get('DB'),'beans');
  }
  
  public function getArticle($f3, $beansId)
  {
    //code to fetch article from DB, requires DB connection
    //load the array into memory
    //force load first row for now
    $this->map->load(array('beans_id=?',$beansId));
    //access individual items from the array
    $articleText = $this->map->review_text;
    $title = $this->map->beans_name;
    $beansName = $this->map->beans_name;
    $author = $this->map->author_id;
    //return array so it can be used in view
    return [
      'articleText' => $articleText,
      'title' => $title,
      'beansName' => $beansName,
      'author' => $author,
    ];
  }
  
  //public function calculateRating($f3)
  //{
  //  //get all ratings from the db, do a quick average, spit it out
  //  return $meanScore;
  //}
  
  public function topFour($f3)
  {
    //load beans table, sort by score, fetch top 4, return array
    // $this->map->load(array('beans_id=?',$beansId));
    $db = $f3->get('DB');
    $rows = $db->exec('SELECT beans_id, beans_name, rating FROM beans ORDER BY rating DESC LIMIT 4');
    return $rows;
  }
  
}
