<?php

namespace General;
echo __FILE__." is included";
use Tracy\Debugger;
Debugger::enable();

$f3 = Base::instance();

/**
 * Forward errors and exceptions to Tracy.
 */

$f3->set('ONERROR', function () use ($f3) {
    Debugger::barDump($f3->get('ERROR'), 'ERROR');

    $e = $f3->get('EXCEPTION');

    // There isn't an exception when calling `Base->error()`.
    if (!$e instanceof Throwable) {
        $e = new Exception('HTTP ' . $f3->get('ERROR.code'));
    }

    Debugger::exceptionHandler($e);
});

/**
 * Routes and controllers.
 */

$f3->route('GET /undefined-method', function (Base $f3, array $args = []) {
    Debugger::barDump(['args' => $args], 'Controller Arguments');
    Debugger::log("Let's try to call an undefined method.");
    (new stdClass)->undefinedMethod();
});

$f3->route('GET /status-400', function (Base $f3, array $args = []) {
    $f3->error(400);
});
