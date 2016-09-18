<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\TimeLimit;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;


class TimeLimitRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return TimeLimit::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return TimeLimit::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return TimeLimit::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $timeLimit = new TimeLimit();
        return $this->assignValues($request, $timeLimit);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $timeLimit = $this->findOrFailById($id);
        return $this->updateValues($request, $timeLimit);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('days', 'id');
    }

    /**
     * @param Request $request
     * @param $timeLimit
     * @return mixed
     */
    private function assignValues(Request $request, $timeLimit)
    {
        $timeLimit->weight = $request->input('weight');
        $timeLimit->days = $request->input('days');

        $timeLimit->save();

        return $timeLimit->id;
    }

    /**
     * @param Request $request
     * @param $timeLimit
     * @return mixed
     */
    private function updateValues(Request $request, $timeLimit)
    {
        $timeLimit->weight = $request->input('weight');
        $timeLimit->days = $request->input('days');


        $timeLimit->save();

        return $timeLimit->id;
    }

    public function next($weight = null)
    {
        if (is_null($weight)) {
            return TimeLimit::orderBy('weight')->first();
        }
        return TimeLimit::where('weight', '>', $weight)->orderBy('weight')->first();
    }

    public function totalDays($timeLimitIds)
    {
        $timeLimits = $this->timeLimitsFromArrayOfId($timeLimitIds);
        return $timeLimits->sum('days');
    }

    public function timeLimitsFromArrayOfId($timeLimitIds) {
        $timeLimitCollection = new Collection();

        foreach ($timeLimitIds as $id) {
            $timeLimit = TimeLimit::where('id', $id)->first();
            $timeLimitCollection->push($timeLimit);
        }

        return $timeLimitCollection;
    }
}