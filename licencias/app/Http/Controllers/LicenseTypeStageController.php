<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseTypeStageRepository;
use CityBoard\Repositories\LicenseTypeRepository;
use CityBoard\Repositories\LicenseStageRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseTypeStageRequest;
use CityBoard\Http\Requests\UpdateLicenseTypeStageRequest;

use Illuminate\Http\Request;

class LicenseTypeStageController extends Controller
{
    protected $licenseTypeStageRepository;
    protected $licenseTypeRepository;
    protected $licenseStageRepository;

    public function __construct()
    {
        $this->licenseTypeStageRepository = new LicenseTypeStageRepository();
        $this->licenseTypeRepository = new LicenseTypeRepository();
        $this->licenseStageRepository = new LicenseStageRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licenseTypes = $this->licenseTypeRepository->selectControl();

        return view('licenseTypeStage.interactive', compact('licenseTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseTypeRepository->selectControl();
        $licenseTypes = $this->licenseTypeRepository->selectControl();
        $licenseStages = $this->licenseStageRepository->selectControl();

        return view('licenseTypeStage.create', compact('licenses', 'licenseTypes', 'licenseStages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseTypeStageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseTypeStageRequest $request)
    {
        $licenseTypeStage_id = $this->licenseTypeStageRepository->create($request);

        return redirect(route('licensetypestage.show', ['id' => $licenseTypeStage_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseTypeStage = $this->licenseTypeStageRepository->findOrFailById($id);

        return view('licenseTypeStage.show', compact('licenseTypeStage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseTypeStage = $this->licenseTypeStageRepository->findOrFailById($id);
        $licenseTypes = $this->licenseTypeRepository->selectControl();
        $licenseStages = $this->licenseStageRepository->selectControl();

        return view('licenseTypeStage.edit', compact('licenseTypeStage', 'licenseTypes', 'licenseStages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseTypeStageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseTypeStageRequest $request, $id)
    {

        $licenseTypeStage_id = $this->licenseTypeStageRepository->update($request, $id);

        return redirect(route('licensetypestage.show', ['id' => $licenseTypeStage_id]));
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

    /**
     * @param $licenseType
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function stagesToJson($licenseType) {
        $stagesForLicenseType = $this->licenseTypeStageRepository->stagesForALicenseType($licenseType);
        $stagesNotForLicenseType = $this->licenseTypeStageRepository->stagesNotForALicenseType($licenseType);

        $response = [
          'allStages' => $stagesNotForLicenseType,
          'customStages' => $stagesForLicenseType,
          'numberAllStages' => count($stagesNotForLicenseType),
          'numberCustomStages' => count($stagesForLicenseType)
        ];

        return response()->json($response, 200);
    }

    public function storeStagesForATypeJson(Request $request, $licenseType)
    {
        $response = $request->json()->all();

        $this->licenseTypeStageRepository->saveJson($licenseType, $response);

        return response()->json($response, 200);
    }
}
