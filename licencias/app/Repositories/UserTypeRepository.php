<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\UserType;
use Illuminate\Http\Request;


class UserTypeRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return UserType::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return UserType::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return UserType::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $userType = new UserType();
        return $this->assignValues($request, $userType);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $userType = $this->findOrFailById($id);
        return $this->updateValues($request, $userType);
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
     * @param $userType
     * @return mixed
     */
    private function assignValues(Request $request, $userType)
    {
        $userType->name = $request->input('name');

        $userType->save();

        return $userType->id;
    }

    /**
     * @param Request $request
     * @param $userType
     * @return mixed
     */
    private function updateValues(Request $request, $userType)
    {

        $userType->name = $request->input('name');

        $userType->save();

        return $userType->id;
    }


}