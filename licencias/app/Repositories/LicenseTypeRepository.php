<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseType;
use Illuminate\Http\Request;


class LicenseTypeRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseType::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseType::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseType::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseType = new LicenseType();
        return $this->assignValues($request, $licenseType);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseType = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseType);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        return $this->all()->lists('name' , 'id');
    }

    /**
     * @param Request $request
     * @param LicenseType $licenseType
     * @return mixed
     */
    private function assignValues(Request $request, LicenseType $licenseType)
    {
        $licenseType->name = $request->input('name');
        $licenseType->description = $request->input('description');
        $licenseType->visit = $this->processingCheckbox($request->input('visit'));
        $licenseType->save();

        return $licenseType->id;
    }

    /**
     * @param Request $request
     * @param LicenseType $licenseType
     * @return mixed
     */
    private function updateValues(Request $request, LicenseType $licenseType)
    {
        $licenseType->name = $request->input('name');
        $licenseType->description = $request->input('description');
        $licenseType->visit = $this->processingCheckbox($request->input('visit'));
        $licenseType->save();

        return $licenseType->id;
    }

    private function processingCheckbox($field)
    {
        if (!isset($field)) {
            return false;
        }

        return true;
    }

}