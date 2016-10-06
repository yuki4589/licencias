<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\Street;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\StreetRepository;

use CityBoard\Http\Requests;
use Illuminate\Http\Request;
use CityBoard\Http\Requests\StoreStreetRequest;
use CityBoard\Http\Requests\UpdateStreetRequest;

class StreetController extends Controller
{
    protected $streetRepository;

    public function __construct()
    {
        $this->streetRepository = new StreetRepository();
    }

    public function getAllStreets(){
        $streets = Street::all();
        $response = [
            'data' => $streets,
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->streetRepository->all()->count();
        $streets = $this->streetRepository->paginate(20);

        return view('street.index', compact('streets', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('street.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStreetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStreetRequest $request)
    {
        $street_id = $this->streetRepository->create($request);

        return redirect(route('street.show', ['id' => $street_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $street = $this->streetRepository->findOrFailById($id);

        return view('street.show', compact('street'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $street = $this->streetRepository->findOrFailById($id);

        return view('street.edit', compact('street'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStreetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStreetRequest $request, $id)
    {

        $street_id = $this->streetRepository->update($request, $id);

        return redirect(route('street.show', ['id' => $street_id]));
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

    public function search(Request $request, $name)
    {
        $streets = Street::where('name', 'LIKE', '%' . $name . '%')->take(20)->get();

        $response = [
          'streets' => $streets,
        ];

        return response()->json($response, 200);
    }
}
