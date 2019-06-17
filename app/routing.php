<?php
// routing.php
$routes = [
    'contact' => [
        ['home', '/', ['GET', 'POST']],
        ['add', '/add', ['GET', 'POST']],
        ['update', '/{id}', ['GET', 'POST']],
        ['change', '/change/{id}', ['GET', 'POST']],
    ],
];