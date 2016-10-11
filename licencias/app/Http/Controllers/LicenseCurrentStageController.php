<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Entities\LicenseStage;
use CityBoard\Entities\LicenseTypeStage;
use CityBoard\Entities\Alert;
use CityBoard\Entities\License;
use CityBoard\Entities\Street;
use CityBoard\Entities\Activity;
use CityBoard\Entities\TimeLimit;
use CityBoard\Http\Controllers\Controller;
use Carbon\Carbon;

use CityBoard\Repositories\LicenseCurrentStageRepository;
use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\LicenseStageRepository;
use CityBoard\Repositories\LicenseTypeStageRepository;
use CityBoard\Repositories\PersonRepository;
use CityBoard\Repositories\FileRepository;
use CityBoard\Repositories\ObjectionRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseCurrentStageRequest;
use CityBoard\Http\Requests\UpdateLicenseCurrentStageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LicenseCurrentStageController extends Controller
{
    protected $licenseCurrentStageRepository;
    protected $licenseTypeStageRepository;
    protected $licenseRepository;
    protected $licenseStageRepository;
    protected $personRepository;
    protected $fileRepository;
    protected $objectionRepository;

    public function __construct()
    {
        $this->licenseCurrentStageRepository = new LicenseCurrentStageRepository();
        $this->licenseTypeStageRepository = new LicenseTypeStageRepository();
        $this->licenseRepository = new LicenseRepository();
        $this->licenseStageRepository = new LicenseStageRepository();
        $this->personRepository = new PersonRepository();
        $this->fileRepository = new FileRepository();
        $this->objectionRepository = new ObjectionRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->licenseCurrentStageRepository->all()->count();
        $licenseCurrentStages = $this->licenseCurrentStageRepository->paginate(20);

        return view('licenseCurrentStage.index',
          compact('licenseCurrentStages', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectControl();
        $licenseStages = $this->licenseStageRepository->selectControl();
        $people = $this->personRepository->selectControl();
        $files = $this->fileRepository->selectControl();
        $objections = $this->objectionRepository->selectControl();

        return view('licenseCurrentStage.create',
          compact('licenses', 'licenseStages', 'people', 'files',
            'objections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseCurrentStageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseCurrentStageRequest $request)
    {
        $licenseCurrentStage_id = $this->licenseCurrentStageRepository->create($request);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseCurrentStage = $this->licenseCurrentStageRepository->findOrFailById($id);
        return view('licenseCurrentStage.show', compact('licenseCurrentStage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseCurrentStage = $this->licenseCurrentStageRepository->findOrFailById($id);
        $file = $licenseCurrentStage->file;
        $licenses = $this->licenseRepository->selectControl();
        $licenseStages = $this->licenseStageRepository->selectControl();
        $people = $this->personRepository->selectControl();

        $objections = $this->objectionRepository->selectControl();

        return view('licenseCurrentStage.edit',
          compact('licenseCurrentStage', 'file', 'licenses', 'licenseStages',
            'people', 'objections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseCurrentStageRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseCurrentStageRequest $request, $id)
    {

        $licenseCurrentStage_id = $this->licenseCurrentStageRepository->update($request,
          $id);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param \CityBoard\Http\Requests\StoreLicenseCurrentStageRequest $request
     * @param $license_id
     * @param $stage_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function saveCurrentStage(
      StoreLicenseCurrentStageRequest $request,
      $license_id,
      $stage_id
    ) {
        $requestJson = $request->json()->all();

        $id = $this->licenseCurrentStageRepository->saveJson($request,
          $requestJson,
          $license_id, $stage_id);

        if (Input::file('file')) {
            $currentStage = $this->licenseCurrentStageRepository->findOrFailById($id);
            $stageFile = $currentStage->file;

            $response = [
              'stageFile' => $stageFile,
            ];

            return response($response, 200);
        }

        if (Input::file('objectionFile')) {
            $currentStage = $this->licenseCurrentStageRepository->findOrFailById($id);
            $stageObjectionFile = $currentStage->objection->file;

            $response = [
              'stageObjectionFile' => $stageObjectionFile,
            ];

            return response($response, 200);
        }


        $current_stage_data = $this->licenseCurrentStageRepository->stageData($license_id, $stage_id);

        $license_data_current_objection = null;
        $objection_id = null;
        $objections = null;
        $stageObjectionNotifications = null;
        $stageObjectionNotificationNext = null;

        if (! is_null($current_stage_data))
        {
            $objections = $current_stage_data->objections->load('firstPersonPosition')->load('secondPersonPosition');
        }

        if (! is_null($current_stage_data) && ! is_null($current_stage_data->objection)) {
            $license_data_current_objection = $current_stage_data->objection;
            $objection_id = $license_data_current_objection->id;
            $stageObjectionNotifications = $license_data_current_objection->objectionNotifications;
            $stageObjectionNotificationNext = $this->objectionRepository->nextTimeLimit($license_data_current_objection);
        }

        $requiredStages = $this->licenseCurrentStageRepository->obtainRequiredStages($license_id);

        $response = [
          'requiredStages' => $requiredStages,
          'objection_id' => $objection_id,
          'stageObjections' => $objections,
          'stageObjectionNotifications' => $stageObjectionNotifications,
          'stageObjectionNotificationNext' => $stageObjectionNotificationNext,
        ];

        if ($request->input('license_stage_id') == 5) {
            $alertNotPrue = Alert::where('license_id', $license_id)
                ->where('type_alert_id', 2)->get();
            foreach ($alertNotPrue as $key => $value) {
                Alert::destroy($value->id);
            }
        }

        return response()->json($response, 200);
    }

    /**
     * @param \CityBoard\Http\Requests\StoreLicenseCurrentStageRequest $request
     * @param $license_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function finishStage(StoreLicenseCurrentStageRequest $request, $license_id)
    {
        $requiredFields = $this->licenseCurrentStageRepository->fieldsRequiredAreFill($license_id);
        $requiredStages = $this->licenseCurrentStageRepository->obtainRequiredStages($license_id);

        if (empty($requiredFields)) {
            $this->licenseRepository->finish($license_id);
        }
        $license = $this->licenseRepository->findOrFailById($license_id);
        
        $response = [
          'license' => $license,
          'requiredFields' => $requiredFields,
          'requiredStages' => $requiredStages,
        ];


        return response()->json($response, 200);
    }

    /**
     * @param $license_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function openStage($license_id)
    {
        $this->licenseRepository->open($license_id);

        return response(200);
    }

    /**
     * @param $license_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentStage($license_id)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);

        if (is_null($license->last_current_stage_id)) {
            $current_stage = $this->licenseCurrentStageRepository->currentStage($license_id);
        } else {
            $current_stage_data = $this->licenseCurrentStageRepository->findOrFailById($license->last_current_stage_id);
            $stage_id = $current_stage_data->licenseStage->id;
            $current_stage = $this->licenseCurrentStageRepository->currentStage($license_id,
              $stage_id);
        }

        $response = $this->getResponseData($license_id, $current_stage);

        return response()->json($response, 200);
    }

    /**
     * @param $license_id
     * @param $stage_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function thisStage($license_id, $stage_id)
    {
        $current_stage = $this->licenseCurrentStageRepository->currentStage($license_id,
          $stage_id);

        $response = $this->getResponseData($license_id, $current_stage);

        return response()->json($response, 200);
    }

    /**
     * @param $license_id
     * @param $stage_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function nextStage($license_id, $stage_id)
    {

        $current_stage = $this->licenseCurrentStageRepository->nextStage($license_id,
          $stage_id);

        $response = $this->getResponseData($license_id, $current_stage);

        return response()->json($response, 200);
    }

    /**
     * @param $license_id
     * @param $stage_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function previousStage($license_id, $stage_id)
    {

        $current_stage = $this->licenseCurrentStageRepository->previousStage($license_id,
          $stage_id);

        $response = $this->getResponseData($license_id, $current_stage);

        return response()->json($response, 200);
    }

    /**
     * @param $license_id
     * @param $current_stage
     * @return array
     */
    private function getResponseData($license_id, $current_stage)
    {
        $license = $this->licenseRepository->findOrFailById($license_id);
        $current_stage_data = $this->licenseCurrentStageRepository->stageData($license_id,
          $current_stage->id);
        $next_stage = $this->licenseCurrentStageRepository->nextStage($license_id,
          $current_stage->id);
        $previous_stage = $this->licenseCurrentStageRepository->previousStage($license_id,
          $current_stage->id);
        $currentStageInListOfLicenseTypeStage = $this->licenseTypeStageRepository->currentStageForLicenseType($license_id,
          $current_stage->id);

        $license_data_current_file = null;
        if (!is_null($current_stage_data)) {
            $license_data_current_file = $current_stage_data->file;
        }

        $license_data_current_objection = null;
        if (!is_null($current_stage_data) && !is_null($current_stage_data->objection)) {
            $license_data_current_objection = $current_stage_data->objection;
        }

        $license_data_current_objection_file = null;
        $license_data_current_objection_notifications = null;
        $license_data_current_objection_notification_next = true;
        if (!is_null($license_data_current_objection)) {
            $license_data_current_objection_file = $current_stage_data->objection->file;
            $license_data_current_objection_notifications = $current_stage_data->objection->objectionNotifications()
              ->get();
            $license_data_current_objection_notification_next = $this->objectionRepository->nextTimeLimit($current_stage_data->objection);
        }
        $requiredFields = $this->licenseCurrentStageRepository->fieldsRequiredAreFill($license_id);
        $requiredStages = $this->licenseCurrentStageRepository->obtainRequiredStages($license_id);



        $people = $this->personRepository->all();
        $response = [
          'license' => $license,
          'stageData' => $current_stage_data,
          'stageObjections' => $current_stage_data->objections->load('firstPersonPosition')->load('secondPersonPosition'),
          'stageObjection' => $license_data_current_objection,
          'stageObjectionFile' => $license_data_current_objection_file,
          'stageObjectionNotifications' => $license_data_current_objection_notifications,
          'stageObjectionNotificationNext' => $license_data_current_objection_notification_next,
          'stageFile' => $license_data_current_file,
          'stageFields' => $current_stage,
          'stageFromList' => $currentStageInListOfLicenseTypeStage,
          'stagePrevious' => $previous_stage,
          'stageNext' => $next_stage,
          'requiredFields' => $requiredFields,
          'requiredStages' => $requiredStages,
          'people' => $people,
          'closets' => $this->licenseRepository->closets(),
        ];
        return $response;
    }

    public function saveCurrentStageAlert(StoreLicenseCurrentStageRequest $request,
      $license_id)
    {
        try{
            $licenseAlert = License::find($license_id);

            $descripcion = '';

            $dt = Carbon::parse($request->input('date'));

            $alertPrue = new Alert();

            $alertPrue->license_id = $license_id;
                
            $alertPrue->type_alert_id = 2;
                
            $streets = Street::find($licenseAlert->street_id);
            $activties = Activity::find($licenseAlert->activity_id);
                
            $alertPrue->title = $licenseAlert->expedient_number . ' - Información pública';
                
            $descripcion .= 'Nombre del negocio: ' . $licenseAlert->commerce_name; 
            $descripcion .= "Dirección:  * Calle ". $streets->name . ' número: ' . $licenseAlert->street_number; 
            $descripcion .= "Ciudad: ". $licenseAlert->city; 
            $descripcion .= "Actividad: ". $activties->name; 
                
            $alertPrue->description = $descripcion;
            $dt->addDays((20 + 1));
            $alertPrue->date =  $dt->toDateTimeString();
                
            Alert::create(json_decode($alertPrue, true));
            
            return ['created' => true];
        
        } catch (Exception $e){
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => false], 500);
        }
    }
}
