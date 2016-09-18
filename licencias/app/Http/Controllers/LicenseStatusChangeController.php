<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\LicenseStatusChange;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseRepository;
use CityBoard\Repositories\LicenseStatusRepository;
use CityBoard\Repositories\LicenseStatusChangeRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseStatusChangeRequest;
use CityBoard\Http\Requests\UpdateLicenseStatusChangeRequest;

class LicenseStatusChangeController extends Controller
{
    protected $licenseRepository;
    protected $licenseStatusRepository;
    protected $licenseStatusChangeRepository;

    public function __construct()
    {
        $this->licenseRepository = new LicenseRepository();
        $this->licenseStatusRepository = new LicenseStatusRepository();
        $this->licenseStatusChangeRepository = new LicenseStatusChangeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->licenseStatusChangeRepository->all()->count();
        $licenseStatusChanges = $this->licenseStatusChangeRepository->paginate(20);

        return view('licenseStatusChange.index', compact('licenseStatusChanges', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $licenses = $this->licenseRepository->selectControl();
        $licenseStatus = $this->licenseStatusRepository->selectControl();

        return view('licenseStatusChange.create', compact('licenses', 'licenseStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseStatusChangeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseStatusChangeRequest $request)
    {
        $licenseStatusChange_id = $this->licenseStatusChangeRepository->create($request);

        return redirect(route('licensestatuschange.show', ['id' => $licenseStatusChange_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseStatusChange = $this->licenseStatusChangeRepository->findOrFailById($id);

        return view('licenseStatusChange.show', compact('licenseStatusChange'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseStatusChange = $this->licenseStatusChangeRepository->findOrFailById($id);
        $licenses = $this->licenseRepository->selectControl();
        $licenseStatuses = $this->licenseStatusRepository->selectControl();

        return view('licenseStatusChange.edit', compact('licenseStatusChange', 'licenses', 'licenseStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseStatusChangeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseStatusChangeRequest $request, $id)
    {
        $licenseStatusChange_id = $this->licenseStatusChangeRepository->update($request, $id);

        return redirect(route('licensestatuschange.show', ['id' => $licenseStatusChange_id]));
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
}
