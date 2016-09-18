<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\PersonPositionRepository;
use CityBoard\Repositories\PersonRepository;
use CityBoard\Repositories\UserTypeRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StorePersonRequest;
use CityBoard\Http\Requests\UpdatePersonRequest;

class PersonController extends Controller
{
    protected $personRepository;
    protected $personPositionRepository;
    protected $userTypeRepository;

    public function __construct()
    {
        $this->personRepository = new PersonRepository();
        $this->personPositionRepository = new PersonPositionRepository();
        $this->userTypeRepository = new UserTypeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->personRepository->all()->count();
        $people = $this->personRepository->paginate(20);

        return view('person.index', compact('people', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personPositions = $this->personPositionRepository->selectControl();
        $userTypes = $this->userTypeRepository->selectControl();

        return view('person.create', compact('personPositions', 'userTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $person_id = $this->personRepository->create($request);

        return redirect(route('person.show', ['id' => $person_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = $this->personRepository->findOrFailById($id);

        return view('person.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = $this->personRepository->findOrFailById($id);
        $personPositions = $this->personPositionRepository->selectControl();
        $userTypes = $this->userTypeRepository->selectControl();

        return view('person.edit', compact('person', 'personPositions', 'userTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePersonRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, $id)
    {

        $person_id = $this->personRepository->update($request, $id);

        return redirect(route('person.show', ['id' => $person_id]));
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
