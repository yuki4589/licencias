<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Street;
use Illuminate\Http\Request;


class StreetRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Street::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Street::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Street::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $street = new Street();
        return $this->assignValues($request, $street);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $street = $this->findOrFailById($id);
        return $this->updateValues($request, $street);
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
     * @param $street
     * @return mixed
     */
    private function assignValues(Request $request, $street)
    {
        $street->name = $request->input('name');

        $street->save();

        return $street->id;
    }

    /**
     * @param Request $request
     * @param $street
     * @return mixed
     */
    private function updateValues(Request $request, $street)
    {

        $street->name = $request->input('name');

        $street->save();

        return $street->id;
    }

    public function findIdByName($streetName) {
        $street = Street::where('name', $streetName)->first();
        
        if (is_null($street)) return null;
        
        return $street->id;
    }


}