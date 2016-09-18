<?php

namespace CityBoard\Http\Controllers;

use Carbon\Carbon;
use CityBoard\Entities\Objection;
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

        return response()->json($response);
    }

    public function openObjection(UpdateObjectionRequest $request, $objection_id) {
        $objection = $this->objectionRepository->saveOpenObjection($objection_id);

        $response = [
          'stageCorrectionDate' => $objection->correction_date,
        ];

        return response()->json($response);
    }
}
