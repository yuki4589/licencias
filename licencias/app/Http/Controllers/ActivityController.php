<?php

namespace CityBoard\Http\Controllers;

use CityBoard\Entities\Activity;
use CityBoard\Http\Controllers\Controller;

use CityBoard\Repositories\ActivityRepository;

use CityBoard\Http\Requests;
use Illuminate\Http\Request;
use CityBoard\Http\Requests\StoreActivityRequest;
use CityBoard\Http\Requests\UpdateActivityRequest;

class ActivityController extends Controller
{
    protected $activityRepository;

    public function __construct()
    {
        $this->activityRepository = new ActivityRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = $this->activityRepository->all()->count();
        $activities = $this->activityRepository->paginate(20);

        return view('activity.index', compact('activities', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActivityRequest $request)
    {
        $activity_id = $this->activityRepository->create($request);

        return redirect(route('activity.show', ['id' => $activity_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->activityRepository->findOrFailById($id);

        return view('activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = $this->activityRepository->findOrFailById($id);

        return view('activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateActivityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActivityRequest $request, $id)
    {

        $activity_id = $this->activityRepository->update($request, $id);

        return redirect(route('activity.show', ['id' => $activity_id]));
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
        $activities = Activity::where('name', 'LIKE', '%' . $name . '%')->take(20)->get();

        $response = [
          'activities' => $activities,
        ];


        return response()->json($response, 200);
    }
}
