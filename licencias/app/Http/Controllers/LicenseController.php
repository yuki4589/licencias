<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\License;
use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Entities\LicenseStatusChange;
use CityBoard\Entities\Titular;
use CityBoard\Entities\TitularityChange;
use CityBoard\Http\Controllers\Controller;

use Carbon\Carbon;
use CityBoard\Repositories\ActivityRepository;
use CityBoard\Repositories\StreetRepository;
use CityBoard\Repositories\ArchiveRepository;
use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\LicenseStatusRepository;
use CityBoard\Repositories\LicenseTypeRepository;
use CityBoard\Repositories\ObjectionRepository;
use CityBoard\Repositories\PersonPositionRepository;
use CityBoard\Repositories\PersonRepository;
use CityBoard\Repositories\TitularRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseRequest;
use CityBoard\Http\Requests\UpdateLicenseRequest;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    protected $licenseRepository;
    protected $licenseTypeRepository;
    protected $activityRepository;
    protected $streetRepository;
    protected $titularRepository;
    protected $archiveRepository;
    protected $personRepository;
    protected $objectionRepository;
    protected $personPositionRepository;
    protected $licenseStatusRepository;

    public function __construct()
    {
        $this->licenseRepository = new LicenseRepository();
        $this->licenseTypeRepository = new LicenseTypeRepository();
        $this->activityRepository = new ActivityRepository();
        $this->streetRepository = new StreetRepository();
        $this->titularRepository = new TitularRepository();
        $this->archiveRepository = new ArchiveRepository();
        $this->personRepository = new PersonRepository();
        $this->personPositionRepository = new PersonPositionRepository();
        $this->objectionRepository = new ObjectionRepository();
        $this->licenseStatusRepository = new LicenseStatusRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $licenses = License::paginate(20, ['*'], 'licenses');
        $licensesAmount = License::all()->count();
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
        $finishInitialDate = Carbon::now();
        $finishFinalDate = Carbon::now();
        $titularityChanges = TitularityChange::paginate(10, ['*'],'titularityChanges');
        $titularityChangesAmount = TitularityChange::count();

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

        $filterByFinishDate = true;
        $filterByFinishDateField = $request->input('filter_by_finish_date');
        if (! isset($filterByFinishDateField)) {
            $filterByFinishDate = false;
        }

        if ($request->input('filter_by_finish_date') === "0") {
            $filterByFinishDate = false;
        }

        if ($filterByFinishDate) {
            $finishInitialDate = $request->input('finish_initial_date');
            $finishFinalDate = $request->input('finish_final_date');

            $finishedLicensesBetweenDates =
              LicenseCurrentStage::where('license_generate', true)
              ->where('date', '>=', $finishInitialDate)
              ->where('date', '<=', $finishFinalDate)
              ->lists('license_id');

            $licenses = $licenses->whereIn('id', $finishedLicensesBetweenDates);
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

        $licensesAmount = $licenses->count();
        $licenses = $licenses->get();
        $activities = $this->activityRepository->selectControl();
        $licenseTypes = $this->licenseTypeRepository->selectControl();

        $variables = compact(
          'licenses',
          'licenseTypes',
          'licenseTypeId',
          'licenseStatuses',
          'licenseStatusId',
          'activities',
          'activityId',
          'activityName',
          'licensesAmount',
          'expedientNumber',
          'registerNumber',
          'licenseIdentifier',
          'titularNif',
          'titularFirstName',
          'titularLastName',
          'streetId',
          'streetName',
          'streetNumber',
          'filterByFinishDate',
          'finishInitialDate',
          'finishFinalDate',
          'filterByRegisterDate',
          'registerInitialDate',
          'registerFinalDate',
          'titularityChanges',
          'titularityChangesAmount'
        );

        //return view('home', $variables);
        return view('license.index', $variables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenseTypes = $this->licenseTypeRepository->selectControl();
        $activities = $this->activityRepository->selectControl();
        $titulars = $this->titularRepository->selectControl();
        $archives = $this->archiveRepository->selectControl();
        $closets = $this->licenseRepository->closetsSelectControl();

        return view('license.create', compact('licenseTypes', 'activities', 'titulars', 'archives', 'closets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseRequest $request)
    {
        $license_id = $this->licenseRepository->create($request);

        return redirect(route('license.show', ['id' => $license_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $license = $this->licenseRepository->findOrFailById($id);
        $people = $this->personRepository->selectControl();
        $personPositions = $this->personPositionRepository->selectControl();
        
        $visitStatuses = [
          'Solicitud puesta en marcha' => 'Solicitud puesta en marcha',
          'Visita' => 'Visita',
          'Completado' => 'Completado',
        ];

        $rejectStatuses = $this->licenseStatusRepository->rejectSelectControl();
        $successStatuses = $this->licenseStatusRepository->successSelectControl();
        $initialStatus = $this->licenseStatusRepository->initial();
        $reopenStatus = $this->licenseStatusRepository->reopen();
        
        $titularChangeStatuses = [
          'Solicitado' => 'Solicitado',
          'Concedido' => 'Concedido',
          'Desistido' => 'Desistido',
        ];

        return view('license.show', compact('license', 'people', 'personPositions', 'visitStatuses', 'titularChangeStatuses', 'rejectStatuses', 'successStatuses', 'initialStatus', 'reopenStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $license = $this->licenseRepository->findOrFailById($id);
        $licenseTypes = $this->licenseTypeRepository->selectControl();
        $activities = $this->activityRepository->selectControl();
        $titulars = $this->titularRepository->selectControl();
        $archives = $this->archiveRepository->selectControl();
        $closets = $this->licenseRepository->closetsSelectControl();

        return view('license.edit', compact('license', 'licenseTypes', 'activities', 'titulars', 'archives', 'closets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseRequest $request, $id)
    {
        $license_id = $this->licenseRepository->update($request, $id);

        return redirect(route('license.show', ['id' => $license_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function openLicense($license_id) {
        $this->licenseRepository->open($license_id);
        $license = $this->licenseRepository->findOrFailById($license_id);
        
        $response = [
          'license' => $license,
        ];

        return response()->json($response, 200);
    }

    public function saveVisitStatus(Request $request, $license_id) {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $requestJson = $request->json()->all();
        $license->visit_status = $requestJson['visitStatus'];
        $license->save();
    }
    
    public function changeStatusLicense(Request $request, $license_id) {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $license->license_status_id = $request->input('status_id');
        $license->finished = true;
        $license->save();
        
        $licenseStatusChange = new LicenseStatusChange();

        $licenseStatusChange->license_id = $license->id;
        $licenseStatusChange->license_status_id = $request->input('status_id');
        $licenseStatusChange->change_date = Carbon::now();
        $licenseStatusChange->reason = $request->input('reason');

        $licenseStatusChange->save();

        $response = [
          'license' => $license,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeCloset(Request $request, $license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $license->closet = $request->getContent();
        $license->save();
        $response = "Armario cambiado";
        return response()->json($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCloset(Request $request, $license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $license->closet = null;
        $license->save();
        $response = "Armario borrado";
        return response()->json($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeVolumeYear(Request $request, $license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $license->closet = null;
        $license->volume_year = $request->getContent();
        $license->save();
        $response = "Tomo/año cambiado";
        return response()->json($response, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOnQuery(Request $request, $license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);

        if ($request->getContent() == "false") {
            $license->on_query = false;
        } else {
            $license->on_query = true;
        }

        $license->save();

        $response = [
            'status' => $license->on_query,
        ];

        return response()->json($response, 200);
    }

    /**
    * Get the object license
    * @param int $id
    * @return $license 
    */
    public function getLicense($id)
    {
      
      $license = $this->licenseRepository->findOrFailById($id);
        
      $response = [
        'object' => $license,
      ];

      return response()->json($response, 200);
    }
}
