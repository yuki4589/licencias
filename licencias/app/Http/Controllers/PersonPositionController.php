<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\PersonPositionRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StorePersonPositionRequest;
use CityBoard\Http\Requests\UpdatePersonPositionRequest;

class PersonPositionController extends Controller
{
    protected $personPositionRepository;

    public function __construct()
    {
        $this->personPositionRepository = new PersonPositionRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->personPositionRepository->all()->count();
        $personPositions = $this->personPositionRepository->paginate(20);

        return view('personPosition.index', compact('personPositions', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('personPosition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePersonPositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonPositionRequest $request)
    {
        $person_position_id = $this->personPositionRepository->create($request);

        return redirect(route('personposition.show', ['id' => $person_position_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personPosition = $this->personPositionRepository->findOrFailById($id);

        return view('personPosition.show', compact('personPosition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personPosition = $this->personPositionRepository->findOrFailById($id);

        return view('personPosition.edit', compact('personPosition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePersonPositionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonPositionRequest $request, $id)
    {

        $person_position_id = $this->personPositionRepository->update($request, $id);

        return redirect(route('personposition.show', ['id' => $person_position_id]));
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
