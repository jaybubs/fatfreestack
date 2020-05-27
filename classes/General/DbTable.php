<?php

namespace General;
use DB;
/**
 * Class DbTable
 * @author yourname
 * for all general purposes db manipulation using f3
 */
class DbTable
{
  public function findById($f3) {
    //needs table, key
    $table = $f3->get('table');
    $lookupValue = $f3->get('lookupValue');
    $db = $f3->get('DB');
    return null;
  }
  
}
