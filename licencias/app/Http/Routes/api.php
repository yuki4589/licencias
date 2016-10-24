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

    //Obtener tipos de Actividades
    Route::get('getAllActivities', 'ActivityController@getAllActivities');

    //Obtener todas las calles
    Route::get('getAllStreets', 'StreetController@getAllStreets');


    //Obtener status
    Route::get('getAllLicenseStatus', 'LicenseStatusController@getAllLicenseStatus');

    //Obetner types
    Route::get('getAllLicenseType', 'LicenseTypeStageController@getAllLicenseType');

    //Obtener licencias
    Route::get('getlicensespendietes', 'LicenseController@getLicensePendiente');

});
