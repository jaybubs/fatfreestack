<?php

namespace Cofdb\Controllers;

class Animal
{
  public $name;
  public $type;
  public $grillable;
  
  public function __construct($name, $age, bool $grillable)
    {
      $this->name=$name;
      $this->type=$type;
      $this->grillable=$grillable;
    }

  public function grillability()
    {
      if ($this->grillable) {
              print("grill it</br>");
            } else {
              print("don't you dare</br>");
            }
    }
}

