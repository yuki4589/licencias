<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseStageRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseStageRequest;
use CityBoard\Http\Requests\UpdateLicenseStageRequest;

class LicenseStageController extends Controller
{
    protected $licenseStageRepository;

    public function __construct()
    {
        $this->licenseStageRepository = new LicenseStageRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->licenseStageRepository->all()->count();
        $licenseStages = $this->licenseStageRepository->paginate(20);

        return view('licenseStage.index', compact('licenseStages', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('licenseStage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseStageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseStageRequest $request)
    {
        $licenseStage_id = $this->licenseStageRepository->create($request);

        return redirect(route('licensestage.show', ['id' => $licenseStage_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseStage = $this->licenseStageRepository->findOrFailById($id);

        return view('licenseStage.show', compact('licenseStage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseStage = $this->licenseStageRepository->findOrFailById($id);

        return view('licenseStage.edit', compact('licenseStage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseStageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseStageRequest $request, $id)
    {

        $licenseStage_id = $this->licenseStageRepository->update($request, $id);

        return redirect(route('licensestage.show', ['id' => $licenseStage_id]));
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

    public function licenseStagesToJson()
    {
        return response($this->licenseStageRepository->all()->toArray(), 200)
          ->header('Content-Type', 'Application/json');
    }
}
