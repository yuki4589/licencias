<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\PersonPosition;
use Illuminate\Http\Request;


class PersonPositionRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return PersonPosition::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return PersonPosition::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return PersonPosition::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $personPosition = new PersonPosition();
        return $this->assignValues($request, $personPosition);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $personPosition = $this->findOrFailById($id);
        return $this->updateValues($request, $personPosition);
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
     * @param PersonPosition $personPosition
     * @return mixed
     */
    private function assignValues(Request $request, PersonPosition $personPosition)
    {
        $personPosition->name = $request->input('name');

        $personPosition->save();

        return $personPosition->id;
    }

    /**
     * @param Request $request
     * @param PersonPosition $personPosition
     * @return mixed
     */
    private function updateValues(Request $request, PersonPosition $personPosition)
    {

        $personPosition->name = $request->input('name');

        $personPosition->save();

        return $personPosition->id;
    }

    public function obtainDefaultPersonPosition() {
        return 1;
    }


}