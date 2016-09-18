<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\LicenseTypeRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreLicenseTypeRequest;
use CityBoard\Http\Requests\UpdateLicenseTypeRequest;

class LicenseTypeController extends Controller
{
    protected $licenseTypeRepository;

    public function __construct()
    {
        $this->licenseTypeRepository = new LicenseTypeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->licenseTypeRepository->all()->count();
        $licenseTypes = $this->licenseTypeRepository->paginate(20);

        return view('licenseType.index', compact('licenseTypes', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('licenseType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLicenseTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLicenseTypeRequest $request)
    {
        $licenseType_id = $this->licenseTypeRepository->create($request);

        return redirect(route('licensetype.show', ['id' => $licenseType_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenseType = $this->licenseTypeRepository->findOrFailById($id);

        return view('licenseType.show', compact('licenseType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $licenseType = $this->licenseTypeRepository->findOrFailById($id);

        return view('licenseType.edit', compact('licenseType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLicenseTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLicenseTypeRequest $request, $id)
    {

        $licenseType_id = $this->licenseTypeRepository->update($request, $id);

        return redirect(route('licensetype.show', ['id' => $licenseType_id]));
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
