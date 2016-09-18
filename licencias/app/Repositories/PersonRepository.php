<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Person;
use Illuminate\Http\Request;


class PersonRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Person::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Person::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Person::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $person = new Person();
        return $this->assignValues($request, $person);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $person = $this->findOrFailById($id);
        return $this->updateValues($request, $person);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('full_name', 'id');
    }

    /**
     * @param Request $request
     * @param Person $person
     * @return mixed
     */
    private function assignValues(Request $request, Person $person)
    {
        $person->first_name = $request->input('first_name');
        $person->last_name = $request->input('last_name');
        $person->person_position_id = $request->input('person_position_id');
        $person->email = $request->input('email');

        $person->save();

        return $person->id;
    }

    /**
     * @param Request $request
     * @param Person $person
     * @return mixed
     */
    private function updateValues(Request $request, Person $person)
    {
        $person->first_name = $request->input('first_name');
        $person->last_name = $request->input('last_name');
        $person->person_position_id = $request->input('person_position_id');
        $person->email = $request->input('email');

        $person->save();

        return $person->id;
    }


}