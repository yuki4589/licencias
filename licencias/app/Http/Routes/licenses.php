<?php
/**
 * Created by PhpStorm.
 * User: taxque
 * Date: 25/09/16
 * Time: 01:22 AM
 */

// Todos
Route::group(['middleware' => 'auth'], function () {
    // Busqueda de rutas
    Route::get('/street/search/{name}',
        ['as' => 'streetSearch', 'uses' => 'StreetController@search']);
    // Busqueda de actividades de los negocios
    Route::get('/activity/search/{name}',
        ['as' => 'activitySearch', 'uses' => 'ActivityController@search']);
    // Busqueda por titulares
    Route::get('/titular/search/{nif}',
        ['as' => 'titularSearch', 'uses' => 'TitularController@search']);
    // Busqueda de prestamos
    Route::put('license/{license_id}/loan/close', 'LoanController@saveCloseLoan');
    Route::put('license/{license_id}/loan', 'LoanController@saveLoan');

    // Gestion de licencias
    Route::get('getlicense/{id}', 'LicenseController@getLicense');
    Route::get('license/{license_id}/stage/{stage_id}',
        'LicenseCurrentStageController@thisStage');
    Route::put('license/{license_id}/closet', 'LicenseController@changeCloset');
    Route::delete('license/{license_id}/closet',
        'LicenseController@deleteCloset');
    Route::put('license/{license_id}/volumeyear',
        'LicenseController@changeVolumeYear');
    Route::put('license/{license_id}/onquery', 'LicenseController@changeOnQuery');
    Route::resource('license', 'LicenseController');


    // Servicios para gestion de pasos
    Route::get('licensestagestojson',
        'LicenseStageController@licenseStagesToJson');
    Route::get('licensestagestojson/licensetype/{licenseType}',
        'LicenseTypeStageController@stagesToJson');
    Route::put('licensestagestojson/licensetype/{licenseType}',
        'LicenseTypeStageController@storeStagesForATypeJson');

    Route::get('currentstage/{license_id}',
        'LicenseCurrentStageController@currentStage');
    Route::post('currentstage/{license_id}/stage/{stage_id}',
        'LicenseCurrentStageController@saveCurrentStage');
    Route::post('finishstage/{license_id}',
        'LicenseCurrentStageController@finishStage');
    Route::post('changestatuslicense/{license_id}',
        'LicenseController@changeStatusLicense');
    Route::post('openlicense/{license_id}', 'LicenseController@openLicense');
    Route::post('savevisitstatus/{license_id}',
        'LicenseController@saveVisitStatus');
    Route::get('nextstage/{license_id}/stage/{stage_id}',
        'LicenseCurrentStageController@nextStage');
    Route::get('previousstage/{license_id}/stage/{stage_id}',
        'LicenseCurrentStageController@previousStage');

    // Gestion de reparos
    Route::post('nextobjectionnotification/{objection_id}',
        'ObjectionController@nextObjectionNotification');
    Route::post('closeobjection/{objection_id}',
        'ObjectionController@closeObjection');
    Route::post('openobjection/{objection_id}',
        'ObjectionController@openObjection');
    Route::post('openobjection/{objection_id}',
        'ObjectionController@openObjection');
    Route::delete('objection/{objection_id}/notification/{notification_id}',
        'ObjectionNotificationController@destroy');

    // Cambios de titularidad
    Route::get('license/titularitychange/{license}', [
        'as' => 'license.titularitychange',
        'uses' => 'TitularityChangeController@createFromLicense'
    ]);
    Route::get('license/titularitychange/{license}/{titularityChange}/edit', [
        'as' => 'license.titularitychange.edit',
        'uses' => 'TitularityChangeController@editFromLicense'
    ]);
    Route::get('license/denunciation/{license}', [
        'as' => 'license.denunciation',
        'uses' => 'DenunciationController@createFromLicense'
    ]);
    Route::get('license/denunciation/{license}/{denunciation}/edit', [
        'as' => 'license.denunciation.edit',
        'uses' => 'DenunciationController@editFromLicense'
    ]);
    Route::put('titularstatuschange/{titularChange}/change', [
        'as' => 'titularitychange.change',
        'uses' => 'TitularityChangeController@change'
    ]);

    // Descarga de archivos
    Route::get('file/download/{file}',
        ['as' => 'file.download', 'uses' => 'FileController@download']);

    // Guarda las alertas en el modal
    Route::post('alertmodal', 'AlertController@createModal');
    Route::get('getalertlicense/{id}', 'AlertController@getAlertLicenses');
    Route::delete('delete/alert/{id}', 'AlertController@destroy');
    Route::get('calendario', [
        'as' => 'calendario', 
        function () { return view('alert.calendario'); }]);
    Route::get('gettypealert', 'AlertController@getTypeAlert');
    Route::get('getalertcalendar', 'AlertController@getAlertCalendar');
    Route::resource('alert', 'AlertController');
});


// Administrador
Route::group(['middleware' => ['auth','admin']], function () {
    // Tipos de Licencias
    Route::resource('licensetype', 'LicenseTypeController');
    // Gestion de direcciones
    Route::resource('street', 'StreetController');
    // Gestion de actividades
    Route::resource('activity', 'ActivityController');
    // Gestion de archivadores
    Route::resource('archive', 'ArchiveController');
    // Gestion de titulares
    Route::resource('titular', 'TitularController');
    // Gestion de posiciones
    Route::resource('personposition', 'PersonPositionController');
    // Gestion de personas para visita( en base a su posicion)
    Route::resource('person', 'PersonController');
    // Gestion de prestamos
    Route::resource('loan', 'LoanController');
    // Gestion de reparos
    Route::resource('objection', 'ObjectionController');
    // Notificaciones de reparos
    Route::resource('objectionnotification', 'ObjectionNotificationController');
    // Estados de licencias
    Route::resource('licensestatus', 'LicenseStatusController');
    // Cambios de licencias
    Route::resource('licensestatuschange', 'LicenseStatusChangeController');
    // Gestion de denuncias
    Route::resource('denunciation', 'DenunciationController');
    // Gestion de archivos
    Route::resource('file', 'FileController');
    // Tipos de usuarios
    Route::resource('usertype', 'UserTypeController');
    // Gestion de tiempos de limites de entregas
    Route::resource('timelimit', 'TimeLimitController');
    // Gestion de Pasos de Licencia
    Route::resource('licensestage', 'LicenseStageController');
    // Gestion de estapas de licencias
    Route::resource('licensecurrentstage', 'LicenseCurrentStageController');
    // Asignacion de pasos en licencias
    Route::resource('licensetypestage', 'LicenseTypeStageController');
    // Gestion de cambios de titularidad
    Route::resource('titularitychange', 'TitularityChangeController');

});


// Usuario Comun
Route::group(['middleware' => ['auth','user']], function () {

});

