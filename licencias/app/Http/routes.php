<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

require __DIR__ . '/Routes/auth.php';
require __DIR__ . '/Routes/licenses.php';

// Rutas de consumo Angular
require __DIR__ . '/Routes/api.php';

