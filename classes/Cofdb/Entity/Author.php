<?php

namespace Cofdb\Entity;

/**
 * Class Author
 * @author yourname
 */
class Author
{
  public function addReview()
  {
    //some function for pushing the review into the db
  }

  public function editReview($reviewId)
  {
    //do what it says on the tin
  }

  public function addCoffee()
  {
    //add information about coffee into the db, the user might not necessarily want to add a review so this should be able to add just the basics, might be useful to create some conditional function that would check whether the user has filled out the review form too or not and then eggzecute addReview on top of this one or something like that
  }
  
}
