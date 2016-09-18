<?php

namespace CityBoard\Repositories;

use CityBoard\Repositories\RepositoryInterface;
use CityBoard\Entities\LicenseStatusChange;
use Illuminate\Http\Request;


class LicenseStatusChangeRepository implements RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LicenseStatusChange::all();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return LicenseStatusChange::paginate($number);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFailById($id)
    {
        return LicenseStatusChange::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $licenseStatusChange = new LicenseStatusChange();
        return $this->assignValues($request, $licenseStatusChange);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $licenseStatusChange = $this->findOrFailById($id);
        return $this->updateValues($request, $licenseStatusChange);
    }

    /**
     * @return static
     */
    public function selectControl()
    {
        /**
         * @todo  SelectControl for LicenseStatusChange Entity
         */
        // return $this->all()->lists('name', 'id');
    }

    /**
     * @param Request $request
     * @param LicenseStatusChange $licenseStatusChange
     * @return mixed
     */
    private function assignValues(Request $request, LicenseStatusChange $licenseStatusChange)
    {
        $licenseStatusChange->license_id = $request->input('license_id');
        $licenseStatusChange->license_status_id = $request->input('license_status_id');
        $licenseStatusChange->change_date = $request->input('change_date');
        $licenseStatusChange->save();

        return $licenseStatusChange->id;
    }

    /**
     * @param Request $request
     * @param LicenseStatusChange $licenseStatusChange
     * @return mixed
     */
    private function updateValues(Request $request, LicenseStatusChange $licenseStatusChange)
    {
        $licenseStatusChange->license_id = $request->input('license_id');
        $licenseStatusChange->license_status_id = $request->input('license_status_id');
        $licenseStatusChange->change_date = $request->input('change_date');
        $licenseStatusChange->save();

        return $licenseStatusChange->id;
    }


}