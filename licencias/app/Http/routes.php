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

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => 'auth'], function () {

  Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
  Route::resource('licensetype', 'LicenseTypeController');
  Route::get('/street/search/{name}',
    ['as' => 'streetSearch', 'uses' => 'StreetController@search']);
  Route::resource('street', 'StreetController');
  Route::get('/activity/search/{name}',
    ['as' => 'activitySearch', 'uses' => 'ActivityController@search']);
  Route::resource('activity', 'ActivityController');
  Route::resource('archive', 'ArchiveController');
  Route::get('/titular/search/{nif}',
    ['as' => 'titularSearch', 'uses' => 'TitularController@search']);
  Route::resource('titular', 'TitularController');
  Route::resource('personposition', 'PersonPositionController');
  Route::resource('person', 'PersonController');

  Route::put('license/{license_id}/loan/close', 'LoanController@saveCloseLoan');
  Route::put('license/{license_id}/loan', 'LoanController@saveLoan');
  Route::resource('loan', 'LoanController');

  Route::resource('objection', 'ObjectionController');
  Route::resource('objectionnotification', 'ObjectionNotificationController');
  Route::resource('licensestatus', 'LicenseStatusController');
  Route::resource('licensestatuschange', 'LicenseStatusChangeController');
  Route::resource('denunciation', 'DenunciationController');
  Route::resource('file', 'FileController');
  Route::resource('usertype', 'UserTypeController');
  Route::resource('timelimit', 'TimeLimitController');

  Route::get('license/{license_id}/stage/{stage_id}',
    'LicenseCurrentStageController@thisStage');
  Route::put('license/{license_id}/closet', 'LicenseController@changeCloset');
  Route::delete('license/{license_id}/closet',
    'LicenseController@deleteCloset');

  Route::put('license/{license_id}/volumeyear',
    'LicenseController@changeVolumeYear');
  Route::put('license/{license_id}/onquery', 'LicenseController@changeOnQuery');

  Route::resource('license', 'LicenseController');
  Route::resource('licensestage', 'LicenseStageController');

  Route::get('licensestagestojson',
    'LicenseStageController@licenseStagesToJson');
  Route::get('licensestagestojson/licensetype/{licenseType}',
    'LicenseTypeStageController@stagesToJson');
  Route::put('licensestagestojson/licensetype/{licenseType}',
    'LicenseTypeStageController@storeStagesForATypeJson');


  Route::resource('licensecurrentstage', 'LicenseCurrentStageController');

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

  Route::resource('licensetypestage', 'LicenseTypeStageController');

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
  Route::resource('titularitychange', 'TitularityChangeController');
  Route::get('file/download/{file}',
    ['as' => 'file.download', 'uses' => 'FileController@download']);

});