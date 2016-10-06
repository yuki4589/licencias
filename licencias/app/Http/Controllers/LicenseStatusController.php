<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\LicenseStatus;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseStatusRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseStatusRequest;
use CityBoard\Http\Requests\UpdateLicenseStatusRequest;

class LicenseStatusController extends Controller
{
    protected $licenseStatusRepository;

    public function __construct()
    {
        $this->licenseStatusRepository = new LicenseStatusRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->licenseStatusRepository->all()->count();
        $licenseStatuses = $this->licenseStatusRepository->paginate(20);

        return view('licenseStatus.index', compact('licenseStatuses', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('licenseStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseStatusRequest $request)
    {
        $licenseStatus_id = $this->licenseStatusRepository->create($request);

        return redirect(route('licensestatus.show', ['id' => $licenseStatus_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseStatus = $this->licenseStatusRepository->findOrFailById($id);

        return view('licenseStatus.show', compact('licenseStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseStatus = $this->licenseStatusRepository->findOrFailById($id);

        return view('licenseStatus.edit', compact('licenseStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseStatusRequest $request, $id)
    {

        $licenseStatus_id = $this->licenseStatusRepository->update($request, $id);

        return redirect(route('licensestatus.show', ['id' => $licenseStatus_id]));
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

    public function getAllLicenseStatus(){
        $statuses = LicenseStatus::all();
        $response = [
            'data' => $statuses,
        ];
        return response()->json($response, 200);
    }
}
