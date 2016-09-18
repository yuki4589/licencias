<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\UserTypeRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreUserTypeRequest;
use CityBoard\Http\Requests\UpdateUserTypeRequest;

class UserTypeController extends Controller
{
    protected $userTypeRepository;

    public function __construct()
    {
        $this->userTypeRepository = new UserTypeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->userTypeRepository->all()->count();
        $userTypes = $this->userTypeRepository->paginate(20);

        return view('userType.index', compact('userTypes', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('userType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTypeRequest $request)
    {
        $userType_id = $this->userTypeRepository->create($request);

        return redirect(route('usertype.show', ['id' => $userType_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userType = $this->userTypeRepository->findOrFailById($id);

        return view('userType.show', compact('userType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userType = $this->userTypeRepository->findOrFailById($id);

        return view('userType.edit', compact('userType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTypeRequest $request, $id)
    {

        $userType_id = $this->userTypeRepository->update($request, $id);

        return redirect(route('usertype.show', ['id' => $userType_id]));
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
