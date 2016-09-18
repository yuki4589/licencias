<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\Titular;
use Illuminate\Http\Request;


class TitularRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Titular::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return Titular::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return Titular::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $titular = new Titular();
        return $this->assignValues($request, $titular);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $titular = $this->findOrFailById($id);
        return $this->updateValues($request, $titular);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('nif_full_name', 'id');
    }

    /**
     * @param Request $request
     * @param Titular $titular
     * @return mixed
     */
    private function assignValues(Request $request, Titular $titular)
    {
        $titular->nif = $request->input('nif');
        $titular->first_name = $request->input('first_name');
        $titular->last_name = $request->input('last_name');
        $titular->phone_number = $request->input('phone_number');
        $titular->email = $request->input('email');
        $titular->save();

        return $titular->id;
    }

    /**
     * @param Request $request
     * @param Titular $titular
     * @return mixed
     */
    private function updateValues(Request $request, Titular $titular)
    {
        $titular->nif = $request->input('nif');
        $titular->first_name = $request->input('first_name');
        $titular->last_name = $request->input('last_name');
        $titular->phone_number = $request->input('phone_number');
        $titular->email = $request->input('email');
        $titular->save();

        return $titular->id;
    }


}