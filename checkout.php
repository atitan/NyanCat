<?php

/* load starter */
include './starter.php';

/* start engine in index mode */
$engine = new Nyan_Engine('checkout');
try {
    $engine->run();
} catch(Exception $e) {
    echo 'Error occured: ' . $e->getMessage();
}