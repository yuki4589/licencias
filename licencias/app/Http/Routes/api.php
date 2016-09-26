<?php
/**
 * Created by PhpStorm.
 * User: taxque
 * Date: 25/09/16
 * Time: 09:51 PM
 */

// Rutas para consumo de apis

Route::group(['middleware' => 'auth', 'prefix' => 'api/v1'], function () {

    //Obtener licencias
    Route::get('getlicenses', 'LicenseController@getAllLicense');

    //Obtener tipos de licencias
    Route::get('getLicensesType', 'LicenseController@getAllLicense');
});
