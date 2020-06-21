<?php
$f3 = require __DIR__.'/../lib/base.php';
include __DIR__.'/../classes/Cofdb/CofdbRoutes.php';
include __DIR__.'/../includes/dbconxn.php';

$f3->clear('CACHE');
$f3->set('UI', __DIR__.'/../templates/');
$f3->set('DEBUG', 1);
// $f3->set('CC', 'Cofdb\Controllers\\');
// $f3->set('CM', 'Cofdb\Models\\');
$f3->set('AUTOLOAD', __DIR__.'/../classes/', __DIR__.'/../lib/');
ini_set('display_errors', 1);
error_reporting(E_ALL);
// deal with later:
// $f3->config(__DIR__.'/../includes/routes.ini');

$f3->run();
