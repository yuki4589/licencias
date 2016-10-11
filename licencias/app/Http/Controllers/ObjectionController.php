<?php

namespace CityBoard\Http\Controllers;

use Carbon\Carbon;
use CityBoard\Entities\Objection;
use CityBoard\Entities\Alert;
use CityBoard\Entities\License;
use CityBoard\Entities\Street;
use CityBoard\Entities\Activity;
use CityBoard\Entities\Person;
use CityBoard\Entities\TimeLimit;
use CityBoard\Entities\ObjectionNotification;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseCurrentStageRepository;
use CityBoard\Repositories\ObjectionNotificationRepository;
use CityBoard\Repositories\ObjectionRepository;
use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\PersonPositionRepository;
use CityBoard\Repositories\FileRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreObjectionRequest;
use CityBoard\Http\Requests\UpdateObjectionRequest;
use CityBoard\Repositories\TimeLimitRepository;


class ObjectionController extends Controller
{
    protected $objectionRepository;
    protected $licenseRepository;
    protected $personPositionRepository;
    protected $fileRepository;
    protected $objectionNotificationRepository;
    protected $timeLimitRepository;

    public function __construct()
    {
        $this->objectionRepository = new ObjectionRepository();
        $this->objectionNotificationRepository = new ObjectionNotificationRepository();
        $this->licenseRepository = new LicenseRepository();
        $this->personPositionRepository = new PersonPositionRepository();
        $this->fileRepository = new FileRepository();
        $this->timeLimitRepository = new TimeLimitRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->objectionRepository->all()->count();
        $objections = $this->objectionRepository->paginate(20);

        return view('objection.index', compact('objections', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectControl();
        $positions = $this->personPositionRepository->selectControl();

        return view('objection.create', compact('licenses', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreObjectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectionRequest $request)
    {
        $objection_id = $this->objectionRepository->create($request);

        return redirect(route('objection.show', ['id' => $objection_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objection = $this->objectionRepository->findOrFailById($id);

        return view('objection.show', compact('objection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objection = $this->objectionRepository->findOrFailById($id);
        $file = $objection->file;
        $licenses = $this->licenseRepository->selectControl();
        $personPositions = $this->personPositionRepository->selectControl();

        return view('objection.edit', compact('objection', 'file', 'licenses', 'personPositions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateObjectionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObjectionRequest $request, $id)
    {

        $objection_id = $this->objectionRepository->update($request, $id);

        return redirect(route('objection.show', ['id' => $objection_id]));
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

    public function nextObjectionNotification(UpdateObjectionRequest $request, $objection_id)
    {
        $requestJson = $request->json()->all();
        
        $objection = $this->objectionRepository->findOrFailById($objection_id);
        $objection->first_person_position_id = $request->input('first_person_position_id');
        if($request->input('second_person_position_id')) {
            $objection->second_person_position_id = $request->input('second_person_position_id');
        }
        $objection->report_date = $request->input('report_date');
        $objection->save();

        $this->objectionNotificationRepository->createNewObjectionNotification($requestJson, $objection);

        $response = [
            'stageObjectionNotifications' => $objection->objectionNotifications()->get(),
            'stageObjectionNotificationNext' => $this->objectionRepository->nextTimeLimit($objection),
        ];
        
        return response()->json($response, 200);
    }

    public function closeObjection(UpdateObjectionRequest $request, $objection_id) {
        $requestJson = $request->json()->all();

        $licenseCurrentStageRepository = new LicenseCurrentStageRepository();
        $objection = $this->objectionRepository->saveCloseObjection($requestJson, $objection_id);
        $current_stage_data = $licenseCurrentStageRepository->stageData($objection->license_id,
          $objection->license_stage_id);

        $response = [
            'stageCorrectionDate' => $objection->correction_date,
            'stageObjections' => $current_stage_data->objections->load('firstPersonPosition')->load('secondPersonPosition')
        ];

        $alertNotPrue = Alert::where('license_id', $request->input('license_id'))
            ->where('type_alert_id', 1)->get();
        foreach ($alertNotPrue as $key => $value) {
            Alert::destroy($value->id);
        }

        return response()->json($response);
    }

    public function openObjection(UpdateObjectionRequest $request, $objection_id) {
        $objection = $this->objectionRepository->saveOpenObjection($objection_id);

        $response = [
          'stageCorrectionDate' => $objection->correction_date,
        ];

        return response()->json($response);
    }

    public function createAlert(UpdateObjectionRequest $request) {
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        try{
            $licenseAlert = License::find($request->input('license_id'));
            $dt = Carbon::parse($request->input('notification_date'));
            
            $alertNotPrue = Alert::where('license_id', $request->input('license_id'))
                ->where('type_alert_id', 1)->get();
            
            $descripcion = '';

            $people = Person::find($request->input('first_person_position_id'));

            $alertPrue = new Alert();

            if (!empty(json_decode($alertNotPrue))){
                foreach ($alertNotPrue as $key => $value) {
                    Alert::destroy($value->id);
                }
              $timeLimit = TimeLimit::find(2);
              $dt->addDays(($timeLimit->days + 1));
              $alertPrue->date = $dt->toDateTimeString();
              
              $alertPrue->title = $licenseAlert->expedient_number . ' - Reparo - N2';
            } else {
              $timeLimit = TimeLimit::find(1);
              $dt->addDays(($timeLimit->days + 1));
              $alertPrue->date = $dt->toDateTimeString();
              $alertPrue->title = $licenseAlert->expedient_number . ' - Reparo - N1';
            }

            $alertPrue->license_id = $request->input('license_id');
            
            $alertPrue->type_alert_id = 1;
                
            $streets = Street::find($licenseAlert->street_id);
                
            $activties = Activity::find($licenseAlert->activity_id);
                
            $descripcion .= '* Nombre del negocio: ' . $licenseAlert->commerce_name; 
            $descripcion .= " * Dirección:  ". $streets->name . ' número: ' . $licenseAlert->street_number; 
            $descripcion .= " * Ciudad: ". $licenseAlert->city; 
            $descripcion .= " * Actividad: ". $activties->name; 
            $descripcion .= " * Persona: ". $people->first_name . ' ' . $people->last_name; 
                
            $alertPrue->description = $descripcion;
                
            
                
            Alert::create(json_decode($alertPrue, true));
             
            return ['created' => true];
        
        }catch (Exception $e){
                \Log::info('Error creating user: '.$e);
                return \Response::json(['created' => false], 500);
            }
        ////////////////////////////////////////////////////////////////////////////////////////////
        
    }
}
