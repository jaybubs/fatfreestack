<?php
$db=new DB\SQL(
  'mysql:host=mariadb;port=3306;dbname=cofdb',
  'root',
  'root'
);
$f3->set('DB',$db);
