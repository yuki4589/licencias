<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\TimeLimitRepository;

use CityBoard\Http\Requests;
use CityBoard\Http\Requests\StoreTimeLimitRequest;
use CityBoard\Http\Requests\UpdateTimeLimitRequest;

class TimeLimitController extends Controller
{
    protected $timeLimitRepository;

    public function __construct()
    {
        $this->timeLimitRepository = new TimeLimitRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->timeLimitRepository->all()->count();
        $timeLimits = $this->timeLimitRepository->paginate(20);

        return view('timeLimit.index', compact('timeLimits', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('timeLimit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTimeLimitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeLimitRequest $request)
    {
        $timeLimit_id = $this->timeLimitRepository->create($request);

        return redirect(route('timelimit.show', ['id' => $timeLimit_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timeLimit = $this->timeLimitRepository->findOrFailById($id);

        return view('timeLimit.show', compact('timeLimit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timeLimit = $this->timeLimitRepository->findOrFailById($id);

        return view('timeLimit.edit', compact('timeLimit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTimeLimitRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimeLimitRequest $request, $id)
    {

        $timeLimit_id = $this->timeLimitRepository->update($request, $id);

        return redirect(route('timelimit.show', ['id' => $timeLimit_id]));
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
