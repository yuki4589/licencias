<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Activity;
use Illuminate\Http\Request;


class ActivityRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Activity::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Activity::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Activity::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $activity = new Activity();
        return $this->assignValues($request, $activity);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $activity = $this->findOrFailById($id);
        return $this->updateValues($request, $activity);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('name', 'id');
    }

    /**
     * @param Request $request
     * @param $activity
     * @return mixed
     */
    private function assignValues(Request $request, $activity)
    {
        $activity->name = $request->input('name');

        $activity->save();

        return $activity->id;
    }

    /**
     * @param Request $request
     * @param $activity
     * @return mixed
     */
    private function updateValues(Request $request, $activity)
    {

        $activity->name = $request->input('name');

        $activity->save();

        return $activity->id;
    }

    public function findIdByName($activityName) {
        $activity = Activity::where('name', $activityName)->first();

        if (is_null($activity)) return null;

        return $activity->id;
    }


}