<?php

namespace CityBoard\Http\Controllers;

use Carbon\Carbon;
use CityBoard\Entities\License;
use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Entities\LicenseType;
use CityBoard\Entities\Titular;
use CityBoard\Entities\TitularityChange;
use CityBoard\Entities\Alert;
use CityBoard\Repositories\ActivityRepository;
use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\LicenseStatusRepository;
use CityBoard\Repositories\LicenseTypeRepository;
use CityBoard\Repositories\StreetRepository;
use Illuminate\Http\Request;

use CityBoard\Http\Requests;
use CityBoard\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $licenseTypeRepository;
    protected $licenseStatusRepository;
    protected $licenseRepository;
    protected $activityRepository;
    protected $streetRepository;

    public function __construct()
    {
        $this->licenseRepository = new LicenseRepository();
        $this->licenseTypeRepository = new LicenseTypeRepository();
        $this->licenseStatusRepository = new LicenseStatusRepository();
        $this->activityRepository = new ActivityRepository();
        $this->streetRepository = new StreetRepository();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $licenses = License::where('finished', false)->paginate(10, ['*'], 'licenses');
        $licensesAmount = License::where('finished', false)->count();
        $expedientNumber = null;
        $registerNumber = null;
        $licenseIdentifier = null;
        $titularNif = null;
        $titularFirstName = null;
        $titularLastName = null;
        $streets = $this->streetRepository->selectControl();
        $streetId = null;
        $streetName = null;
        $street = null;
        $streetNumber = null;
        $activities = $this->activityRepository->selectControl();
        $activityId = null;
        $activityName = null;
        $licenseTypes = $this->licenseTypeRepository->selectControl();
        $licenseTypeId = null;
        $licenseStatuses = $this->licenseStatusRepository->selectControl();
        $licenseStatusId = null;
        $registerInitialDate = Carbon::now();
        $registerFinalDate = Carbon::now();
        $titularityChanges = TitularityChange::where('finished', false)->paginate(10, ['*'],'titularityChanges');
        $titularityChangesAmount = TitularityChange::where('finished', false)->count();

        $expedientNumber = $request->input('expedient_number');
        $registerNumber = $request->input('register_number');
        $licenseIdentifier = $request->input('license_identifier');
        $titularNif = $request->input('titular_nif');
        $titularFirstName = $request->input('titular_first_name');
        $titularLastName = $request->input('titular_last_name');
        $streetName = $request->input('street_name');
        $streetId = $this->streetRepository->findIdByName($streetName);
        $streetNumber = $request->input('street_number');
        $activityName = $request->input('activity_name');
        $activityId = $this->activityRepository->findIdByName($activityName);
        $licenseTypeId = $request->input('license_type_id');
        $licenseStatusId = $request->input('license_status_id');

        $filterByRegisterDate = true;
        $filterByRegisterDateField = $request->input('filter_by_register_date');
        if (! isset($filterByRegisterDateField)) {
            $filterByRegisterDate = false;
        }

        if ($request->input('filter_by_register_date') === "0") {
            $filterByRegisterDate = false;
        }

        if ($filterByRegisterDate) {
            $registerInitialDate = $request->input('register_initial_date');
            $registerFinalDate = $request->input('register_final_date');
            $licenses = License::where('register_date', '>=', $registerInitialDate)
              ->where('register_date', '<=', $registerFinalDate);
        } else {
            $licenses = License::where('register_date', '>=', '01-01-1970');
        }

        if ($licenseTypeId) {
            $licenses = $licenses->where('license_type_id', $licenseTypeId);
        }

        if ($licenseStatusId) {
            $licenses = $licenses->where('license_status_id', $licenseStatusId);
        }

        if ($activityId) {
            $licenses = $licenses->where('activity_id', $activityId);
        }
        
        if ($streetId) {
            $licenses = $licenses->where('street_id', $streetId);
        }
        
        if (! empty($expedientNumber)) {
            $licenses = $licenses->where('expedient_number', 'like', '%' . $expedientNumber . '%');
        }

        if (! empty($registerNumber)) {
            $licenses = $licenses->where('register_number', $registerNumber);
        }

        if (! empty($licenseIdentifier)) {
            $licenses = $licenses->where('identifier', $licenseIdentifier);
        }

        if (! empty($titular_nif)) {
            $titulars = Titular::where('nif', 'like', '%' . $titularNif . '%')->lists('id');
            if(! is_null($titulars)) {
                $licenses = $licenses->whereIn('titular_id', $titulars);
            }
        }

        if (! empty($titularFirstName)) {
            $titulars = Titular::where('first_name', 'like', '%' .  $titularFirstName . '%')->lists('id');
            if(! is_null($titulars)) {
                $licenses = $licenses->whereIn('titular_id', $titulars);
            }
        }

        if (! empty($titularLastName)) {
            $titulars = Titular::where('last_name', 'like', '%' . $titularLastName . '%')->lists('id');
            if(! is_null($titulars)) {
                $licenses = $licenses->whereIn('titular_id', $titulars);
            }
        }

        if (! empty($streetNumber)) {
            $licenses = $licenses->where('street_number', 'like', '%' . $streetNumber . '%');
        }

        $licenses = $licenses->where('finished', false)->paginate(10, ['*'],'licenses');
        $licensesAmount = License::where('finished', false)->count();
        $activityCommunicationAmount = License::where('finished', false)->where('license_type_id', 1)->count();
        $withoutQualificationAmount = License::where('finished', false)->where('license_type_id', 2)->count();
        $withQualificationAmount = License::where('finished', false)->where('license_type_id', 3)->count();
        $activities = $this->activityRepository->selectControl();
        $licenseTypes = $this->licenseTypeRepository->selectControl();

        
        
        $typeAlert = Alert::where('type_alert_id', 1)->count();
        $typeAlert2 = Alert::where('type_alert_id', 3)->count();
        $typeAlert3 = Alert::where('type_alert_id', 4)->count();

        

        $variables = compact(
          'licenses',
          'licenseTypes',
          'licenseTypeId',
          'licenseStatuses',
          'licenseStatusId',
          'streets',
          'streetId',
          'streetName',
          'activities',
          'activityId',
          'activityName',
          'licensesAmount',
          'activityCommunicationAmount',
          'withoutQualificationAmount',
          'withQualificationAmount',
          'expedientNumber',
          'registerNumber',
          'licenseIdentifier',
          'titularNif',
          'titularFirstName',
          'titularLastName',
          'streetNumber',
          'filterByRegisterDate',
          'registerInitialDate',
          'registerFinalDate',
          'titularityChanges',
          'titularityChangesAmount',
          'typeAlert',
          'typeAlert2',
          'typeAlert3'
        );

        return view('home', $variables);
    }
}
