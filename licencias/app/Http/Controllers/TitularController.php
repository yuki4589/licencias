<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\Titular;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\TitularRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreTitularRequest;
use CityBoard\Http\Requests\UpdateTitularRequest;
use Illuminate\Http\Request;

class TitularController extends Controller
{
    protected $titularRepository;

    public function __construct()
    {
        $this->titularRepository = new TitularRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->titularRepository->all()->count();
        $titulars = $this->titularRepository->paginate(20);

        return view('titular.index', compact('titulars', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('titular.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTitularRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTitularRequest $request)
    {
        $titular_id = $this->titularRepository->create($request);

        return redirect(route('titular.show', ['id' => $titular_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titular = $this->titularRepository->findOrFailById($id);

        return view('titular.show', compact('titular'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titular = $this->titularRepository->findOrFailById($id);

        return view('titular.edit', compact('titular'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTitularRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTitularRequest $request, $id)
    {

        $titular_id = $this->titularRepository->update($request, $id);

        return redirect(route('titular.show', ['id' => $titular_id]));
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

    public function search(Request $request, $nif)
    {
        $titulars = Titular::where('nif', 'LIKE', '%' . $nif . '%')->take(20)->get();

        $response = [
          'titulars' => $titulars,
        ];


        return response()->json($response, 200);
    }
}
